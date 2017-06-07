<?php
/**
 * ReCaptcha.php File *
 *
 * @package ReCaptcha
 */


/**
 * Render reCaptcha widget and perform all checks.
 *
 * 
 * @author Vitaliy Komlev <mailbox@vkomlev.ru>
 * @version 1.0
 */
class ReCaptcha {
    
    public $private_key = '6LemiCMTAAAAAMq33cdV5Qc5r10Nq138YOzyFPHN';
    
    public $public_key = '6LemiCMTAAAAAIE38IyISWaGu1qcqGF4m5EdHO8_';
    
    public $response_url = 'https://www.google.com/recaptcha/api/siteverify';
    
    
	public function __construct() {
        if (empty($this->private_key))
			throw new CException('reCaptcha private key must be set.');
        
        if (empty($this->private_key))
			throw new CException('reCaptcha public key must be set.');
    }
    
    
    
    public function render() {
        return '<div class="g-recaptcha" data-sitekey="'.$this->public_key.'"></div>';
    }
    
    
    
    public function checkResponse() {
        if (!isset($_POST['g-recaptcha-response']))
			throw new CException('reCaptcha request failed.');
        
        //Prepare variables
        $secret = $this->private_key;
        $response = $_POST['g-recaptcha-response'];
        
        $fields_string = 'secret='.$secret.'&response='.$response;
        
        //open connection and send data
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->response_url);
        curl_setopt($ch, CURLOPT_POST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        //receive data from request
        $result = curl_exec($ch);
        curl_close($ch);
        
        $decoded_result = json_decode($result);
        
        return $decoded_result->success;
    }
}