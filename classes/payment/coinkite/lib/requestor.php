<?php
include('CKException.php');

date_default_timezone_set('UTC');

class CKRequestor {

    private $socks5;

    function __construct($api_key=null, $api_secret=null, $host=null, $client=null) {
        // Provide API Key and secret
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        
        if (!$this->host = $host) {
            $this->host = 'https://api.coinkite.com';
        }
        
        $this->client = $client;
    }

    public function setSocks5($socks5)
    {
        $this->socks5 = $socks5;
    }
    
    function request($method, $endpt, $args=null, $headers=null) {
        /*
        Low level method to perform API request: provide HTTP method and endpoint
        
        Optional arguments:
            $args = JSON document or an array of arguments
            $headers = Extra headers to put on request, must be an array of headers
        */
        
        $url = $this->host . $endpt;
        $endpt = parse_url($url, PHP_URL_PATH);
        
        if (substr($endpt, 0, 7) == '/public') {
            $auth_headers = array();
        } else {
            $auth_headers = $this->auth_headers($endpt);
        }

        if (is_array($headers)) {
            $hdrs = array_merge($auth_headers, $headers);
        } else {
            $hdrs = $auth_headers;
        }

        if (isset($args)) {
            if (is_array($args)) {
                $data = $args;
            } else {
                $data = json_decode($args, true);
            }

            if ($data && $method == 'GET') {
                $url .= '?' . http_build_query($data);
            }
        }

        while (true) {
            $curl = curl_init($url);

            if ( !empty($this->socks5) )
            {
                curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
                curl_setopt($ch, CURLOPT_PROXY, $this->socks5);
            }
            
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $hdrs);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_CAINFO, 'data/ca-certificates.crt');
            
            $body_json = curl_exec($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($status == 504) {
                throw new CKException($status, $body_json);
            }

            $body = json_decode($body_json, true);

            curl_close($curl);

            if ($status == 429 && $body['wait_time']) {
                sleep($body['wait_time']);
            } else {
                break;
            }
        }
        
        if ($status != 200) {
            echo '<pre>';
            print_r($status);
            echo '</pre>';
            throw new CKException($status, $body_json);
        }
            
        return $body;
    }
    
    function make_signature($endpoint, $force_ts=false) {
        // Pick a timestamp and perform the signature required
        if ($force_ts) {
            $ts = $force_ts;
        } else {
            $now = new DateTime();
            $ts = $now->format(DateTime::ISO8601);
        }

        $data = $endpoint . '|' . $ts;
        $hm = hash_hmac('sha256', $data, $this->api_secret);

        return array($hm, $ts);
    }
    
    function auth_headers($endpoint, $force_ts=false) {
        // Make authorization headers that are needed to access indicated endpoint
        if (!$this->api_key) {
            throw new CKException(0, '{"message":"API Key for Coinkite is required"}');
        }

        if (!$this->api_secret) {
            throw new CKException(0, '{"message":"API Secret for Coinkite is required"}');
        }
        
        $sig_ts = $this->make_signature($endpoint, $force_ts);
        
        return array('X-CK-Key: ' . $this->api_key,
                     'X-CK-Timestamp: ' . $sig_ts[1],
                     'X-CK-Sign: ' . $sig_ts[0]);
    }
    
    function get($endpt, $args=null) {
        // Perform a GET on indicated resource (endpoint) with optional arguments
            return $this->request('GET', $endpt, $args);
    }

    function put($endpt, $args=null) {
        // Perform a PUT on indicated resource (endpoint) with optional arguments
        return $this->request('PUT', $endpt, $args);
    }

    function get_iter($endpoint, $offset=0, $limit=null, $batch_size=25, $safety_limit=500, $args=null) {
        // Return a Generator that will iterate over all results, regardless of how many
        while(true) {
            if ($limit && $limit < $batch_size) {
                $batch_size = $limit;
            }
            
            if (isset($args)) {
                if (is_array($args)) {
                    $data = $args;
                } else {
                    $data = json_decode($args, true);
                }
            }
            $data['offset'] = $offset;
            $data['limit'] = $batch_size;
            
            $rv = $this->get($endpoint, $data);
            
            $here = $rv['paging']['count_here'];
            $total = $rv['paging']['total_count'];

            if ($total > $safety_limit) {
                throw new CKException(0, "{\"message\":\"Too many results ($total); consider another approach\"}");
            }
                
            if (!$here) {
                return;
            }
                
            foreach ($rv['results'] as $i) {
                yield $i;
            }
                
            $offset += $here;
            if ($limit) {
                $limit -= $here;
                if ($limit <= 0) {
                    return;
                }
            }
        }
    }

    function check_myself() {
        return $this->request('GET', '/v1/my/self');
    }

    function get_detail($refnum) {
        // Get detailed-view of any CK object by reference number
        $data = $this->request('GET', '/v1/detail/' . $refnum);
        return $data['detail'];
    }

    function get_accounts() {
        // Get a list of accounts, doesn't include balances
        $data = $this->request('GET', '/v1/my/accounts');
        return $data['results'];
    }

    function get_balance($account) {
        // Get account details, including balance, by account name, number or refnum
        $data = $this->request('GET', '/v1/account/' . $account);
        return $data['account'];
    }

    function get_list($what, $account=null, $just_count=false, $args=null) {
        /*
        Get a list of objects, using /v1/list/WHAT endpoints, where WHAT is:
        
            activity
            credits
            debits
            events
            notifications
            receives
            requests
            sends
            sweeps
            transfers
            unauth_sends
            watching
        */
        
        $ep = '/v1/list/' . $what;
        
        if (isset($account)) {
            $args['account'] = $account;
        }
            
        if ($just_count) {
            $args['limit'] = 0;
            $data = $this->get($ep, $args);
            return $data['paging']['total_count'];
        }

        return $this->get_iter($ep);
    }
}
?>
