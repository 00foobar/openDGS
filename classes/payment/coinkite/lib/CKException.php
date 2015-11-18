<?php

class CKException extends Exception {
    function __construct($code, $msg) {
        $this->code = $code;
        $this->msg = $msg;
        
        error_log("[$code] " . $msg);
    }
    
    function __tostring() {
        return $this->printMessage();
    }
    
    function printMessage() {
         $code = $this->code;
         $msg = $this->msg;
         $msg_array = json_decode($msg, true);

         switch ($code){
             case 400:
                 $msg_text = "[$code] \"" . $msg_array['help_msg'] . '"';
                 break;
             case 404:
                 $msg_text = "[$code] \"Problem with HTTPS connection to Coinkite server. " .
                             $msg_array['message'] . '"';
                 break;
             case 504:
                 $msg_text = "[$code] \"A problem with the CF to Coinkite connection\"";
                 break;
             default:
                 $msg_text = "[$code] \"" . $msg_array['message'] . '"';             
         }
         
         return $msg_text;
    }
}

?>
