<?php

class PayPal {
	
    public static function requestPayment($payment_id) {
        $e = new ExpressCheckout;
        $payment = Payments::model()->findByPk($payment_id);

        if (!empty($payment->order))
            $products = $payment->order->itemsList;

        $e->setCurrencyCode("USD");//set Currency (USD,HKD,GBP,EUR,JPY,CAD,AUD)

        $e->setProducts($products); /* Set array of products*/

        $e->API_USERNAME='';
        $e->API_PASSWORD='';
        $e->API_SIGNATURE='';
        $e->SUBJECT=$payment->paypal_id;
        $e->returnURL=Yii::app()->createAbsoluteUrl("paypal/PaypalReturn", array('payment_id' => $payment_id));
        $e->cancelURL=Yii::app()->createAbsoluteUrl("paypal/PaypalCancel", array('payment_id' => $payment_id));
        //$e->returnURL=Yii::app()->createAbsoluteUrl("/my/orders");
        //$e->cancelURL=Yii::app()->createAbsoluteUrl("s");
//echo $e->returnURL;
//die('thats all');
        $result=$e->requestPayment(); 

        /*
        The response format from paypal for a payment request
        Array
        (
        [TOKEN] => EC-9G810112EL503081W
        [TIMESTAMP] => 2013-12-12T10:29:35Z
        [CORRELATIONID] => 67da94aea08c3
        [ACK] => Success
        [VERSION] => 65.1
        [BUILD] => 8725992
        )
        */
        if(strtoupper($result["ACK"])=="SUCCESS") {
            //print_r($result);
            //die('   thats all');
            
            
            /*redirect to the paypal gateway with the given token */
            header("location:".$e->PAYPAL_URL.$result["TOKEN"]);
        } 
    }   
    
}