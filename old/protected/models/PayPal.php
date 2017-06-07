<?php

class PayPal {
	
    public static function requestPayment($payment_id) {
        $e = new ExpressCheckout;
        $payment = Payments::model()->findByPk($payment_id);

        if (!empty($payment->order))
            $products = $payment->order->itemsList;

        $e->setCurrencyCode("USD");//set Currency (USD,HKD,GBP,EUR,JPY,CAD,AUD)

        $e->setProducts($products); /* Set array of products*/


        $e->returnURL=Yii::app()->createAbsoluteUrl("paypal/PaypalReturn", array('payment_id' => $payment_id));
        $e->cancelURL=Yii::app()->createAbsoluteUrl("paypal/PaypalCancel", array('payment_id' => $payment_id));

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
            $order_payment = new Payments;
            $order_payment->order_id = $payment->order_id;
            $order_payment->payment_type = 1;
            $order_payment->type = Payments::TYPE_ORDER;
            $order_payment->amount = $payment->amount;
            $order_payment->payer_name = 'AutoPayment';
            $order_payment->is_approved = 1;
            $order_payment->approved_by = Yii::app()->params['bot']['id'];
            $order_payment->date_approved = date('Y-m-d H:i:s');
            $order_payment->save();
            
            /*redirect to the paypal gateway with the given token */
            header("location:".$e->PAYPAL_URL.$result["TOKEN"]);
        } 
    }   
    
}