<?php
require_once('lib'. DIRECTORY_SEPARATOR . 'requestor.php');

class Coinkite extends CKRequestor
{
	private $account;
	private $return_url;
	private $currency;

	private $description;
	private $price;

	public function __construct($key, $secret)
	{
		parent::__construct($key, $secret);
	}

	public function trimDescription($description)
	{
		if ( strlen($description) >= 199 )
		{
			return substr($description, 0, 199);
		}

		return $description;
	}

	public function setAccount($account)
	{
		if ( strlen($account) < 80 )
		{
			$this->account = $account;

			return true;
		}

		return false;
	}

	public function setPrice($price)
	{
		if ( is_numeric($price) )
		{
			$this->price = round($price, 2);

			return true;			
		}

		throw new Exception("Price must be numeric.", 1);
	}

	public function setDescription($description)
	{
		if ( is_string($description) )
		{
			$this->description = $this->trimDescription($description);

			return true;
		}

		return false;
	}

	public function setReturnURL($url)
	{
		if ( strlen($url) < 256 )
		{
			$this->return_url = $url;

			return true;
		}

		return false;
	}

	public function setCurrency($currency)
	{
		if ( strlen($currency) == 3 )
		{
			$this->currency = strtoupper($currency);

			return true;
		}

		return false;
	}

	public function showPaymentButtonAnonym()
	{
		if ( empty($this->account) )
		{
			throw new Exception("No account name set.", 1);
		}

		if ( empty($this->return_url) )
		{
			throw new Exception("No return/callback url set.", 1);
		}

		if ( empty($this->price) )
		{
			throw new Exception("No price is set.", 1);
		}

		if ( empty($this->currency) )
		{
			$this->currency = 'USD';
		}

		$args = array(
				'account' => $this->account,
				'use_token' => true,
				'description' => $this->trimDescription($this->description),
				'price' => round($this->price, 2),
				'price_cct' => $this->currency,
				'return_url' => $this->return_url,
				);

	 	$endpoint = '/v1/new/button';

	 	$result = $this->get($endpoint, $args);

	 	// @TODO response if fails
	 	return $result;
	}

	public function showPaymentButton()
	{
	 	$endpoint = '/v1/new/button';

		$args = array(
				'account' => 'My Bitcoins',
				'use_token' => true,
				'description' => trimDescription('foobar goes in all fields!'),
				'price' => round(0.05, 2),
				'price_cct' => 'EUR',
				'return_url' => 'http://127.0.0.1/dev/dg/payment_callback.php', 
				'nym' => 'name of nym as string',
				'tracking' => '(string) Your tracking number (free form).',
				'get_email' => true,
				'get_refund_addr' => false,
				'require_refund' => true,
				'get_text' => 'true'
			);
	}
}

?>