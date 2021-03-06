<?php

class PaypalController extends Controller
{
    public function actionPaypalReturn($payment_id)
    {
        $payment = Payments::model()->findByPk($payment_id);
        Yii::log(CVarDumper::dumpAsString($_REQUEST));
        Yii::log(CVarDumper::dumpAsString($payment));
        if (empty($payment) || empty($payment->order) )
            throw new CHttpException(404,'The requested page does not exist.');
        //removed || ($payment->order->client_id != Yii::app()->user->id) 
        //suffer security
        
       
        /*
        here paypal will send you the following 2 parameters
        $_REQUEST[token] => EC-59C81234SW941750C
        $_REQUEST[PayerID] => ZW3KSL2H557XC

        */   
        /* You need to do 2 more final steps to complete the user payment. ie 
        1.get the payment details from payment &
        2.make doPayment api call to paypal to complete the payment 
        */
        
        $e = new ExpressCheckout;
        $paymentDetails=$e->getPaymentDetails($_REQUEST['TOKEN']); //1.get payment details by using the given token
        Yii::log(CVarDumper::dumpAsString($paymentDetails));
        /*
        Below you can see a sample format of a successfull payment details response from paypal
        Array
        (
        [TOKEN] => EC-73B51491U8895353R
        [CHECKOUTSTATUS] => PaymentActionNotInitiated
        [TIMESTAMP] => 2013-12-12T11:03:09Z
        [CORRELATIONID] => b812d7a367878
        [ACK] => Success
        [VERSION] => 65.1
        [BUILD] => 8725992
        [EMAIL] => sirini_1313434856_per@gmail.com
        [PAYERID] => ZW3KSL2H557XC
        [PAYERSTATUS] => verified
        [FIRSTNAME] => Test
        [LASTNAME] => User
        [COUNTRYCODE] => US
        [SHIPTONAME] => Test User
        [SHIPTOSTREET] => 1 Main St
        [SHIPTOCITY] => San Jose
        [SHIPTOSTATE] => CA
        [SHIPTOZIP] => 95131
        [SHIPTOCOUNTRYCODE] => US
        [SHIPTOCOUNTRYNAME] => United States
        [ADDRESSSTATUS] => Confirmed
        [CURRENCYCODE] => USD
        [AMT] => 1800.00
        [ITEMAMT] => 1800.00
        [SHIPPINGAMT] => 0.00
        [HANDLINGAMT] => 0.00
        [TAXAMT] => 0.00
        [INSURANCEAMT] => 0.00
        [SHIPDISCAMT] => 0.00
        [L_NAME0] => p1
        [L_NAME1] => p2
        [L_NAME2] => p3
        [L_QTY0] => 2
        [L_QTY1] => 2
        [L_QTY2] => 2
        [L_TAXAMT0] => 0.00
        [L_TAXAMT1] => 0.00
        [L_TAXAMT2] => 0.00
        [L_AMT0] => 250.00
        [L_AMT1] => 300.00
        [L_AMT2] => 350.00
        [L_ITEMWEIGHTVALUE0] =>    0.00000
        [L_ITEMWEIGHTVALUE1] =>    0.00000
        [L_ITEMWEIGHTVALUE2] =>    0.00000
        [L_ITEMLENGTHVALUE0] =>    0.00000
        [L_ITEMLENGTHVALUE1] =>    0.00000
        [L_ITEMLENGTHVALUE2] =>    0.00000
        [L_ITEMWIDTHVALUE0] =>    0.00000
        [L_ITEMWIDTHVALUE1] =>    0.00000
        [L_ITEMWIDTHVALUE2] =>    0.00000
        [L_ITEMHEIGHTVALUE0] =>    0.00000
        [L_ITEMHEIGHTVALUE1] =>    0.00000
        [L_ITEMHEIGHTVALUE2] =>    0.00000
        [PAYMENTREQUEST_0_CURRENCYCODE] => USD
        [PAYMENTREQUEST_0_AMT] => 1800.00
        [PAYMENTREQUEST_0_ITEMAMT] => 1800.00
        [PAYMENTREQUEST_0_SHIPPINGAMT] => 0.00
        [PAYMENTREQUEST_0_HANDLINGAMT] => 0.00
        [PAYMENTREQUEST_0_TAXAMT] => 0.00
        [PAYMENTREQUEST_0_INSURANCEAMT] => 0.00
        [PAYMENTREQUEST_0_SHIPDISCAMT] => 0.00
        [PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED] => false
        [PAYMENTREQUEST_0_SHIPTONAME] => Test User
        [PAYMENTREQUEST_0_SHIPTOSTREET] => 1 Main St
        [PAYMENTREQUEST_0_SHIPTOCITY] => San Jose
        [PAYMENTREQUEST_0_SHIPTOSTATE] => CA
        [PAYMENTREQUEST_0_SHIPTOZIP] => 95131
        [PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE] => US
        [PAYMENTREQUEST_0_SHIPTOCOUNTRYNAME] => United States
        [PAYMENTREQUEST_0_ADDRESSSTATUS] => Confirmed
        [L_PAYMENTREQUEST_0_NAME0] => p1
        [L_PAYMENTREQUEST_0_NAME1] => p2
        [L_PAYMENTREQUEST_0_NAME2] => p3
        [L_PAYMENTREQUEST_0_QTY0] => 2
        [L_PAYMENTREQUEST_0_QTY1] => 2
        [L_PAYMENTREQUEST_0_QTY2] => 2
        [L_PAYMENTREQUEST_0_TAXAMT0] => 0.00
        [L_PAYMENTREQUEST_0_TAXAMT1] => 0.00
        [L_PAYMENTREQUEST_0_TAXAMT2] => 0.00
        [L_PAYMENTREQUEST_0_AMT0] => 250.00
        [L_PAYMENTREQUEST_0_AMT1] => 300.00
        [L_PAYMENTREQUEST_0_AMT2] => 350.00
        [L_PAYMENTREQUEST_0_ITEMWEIGHTVALUE0] =>    0.00000
        [L_PAYMENTREQUEST_0_ITEMWEIGHTVALUE1] =>    0.00000
        [L_PAYMENTREQUEST_0_ITEMWEIGHTVALUE2] =>    0.00000
        [L_PAYMENTREQUEST_0_ITEMLENGTHVALUE0] =>    0.00000
        [L_PAYMENTREQUEST_0_ITEMLENGTHVALUE1] =>    0.00000
        [L_PAYMENTREQUEST_0_ITEMLENGTHVALUE2] =>    0.00000
        [L_PAYMENTREQUEST_0_ITEMWIDTHVALUE0] =>    0.00000
        [L_PAYMENTREQUEST_0_ITEMWIDTHVALUE1] =>    0.00000
        [L_PAYMENTREQUEST_0_ITEMWIDTHVALUE2] =>    0.00000
        [L_PAYMENTREQUEST_0_ITEMHEIGHTVALUE0] =>    0.00000
        [L_PAYMENTREQUEST_0_ITEMHEIGHTVALUE1] =>    0.00000
        [L_PAYMENTREQUEST_0_ITEMHEIGHTVALUE2] =>    0.00000
        [PAYMENTREQUESTINFO_0_ERRORCODE] => 0
        )
        */
        if ($paymentDetails['ACK']=="Success") {
            $result=$e->doPayment($paymentDetails);  //2.Do payment

            if ($result['ACK']=='Success'){
                $payment->approved_by = Yii::app()->params['bot']['id'];
               // $order_payment = new Payments;
                $payment->order_id = $payment->order_id;
                $payment->payment_type = 1;
                $payment->type = Payments::TYPE_ORDER;
                $payment->amount = $payment->amount;
                $payment->payer_name = $_REQUEST['FIRSTNAME'].' '.$_REQUEST['LASTNAME'];
                $payment->is_approved = 1;
                $payment->date_approved = date('Y-m-d H:i:s');
                $payment->save(); 
                $mail = new MailForms();
                $result = $mail->sendNotification('New Order', "new order:".$payment->order_id , $payment->client->email);
                $this->redirect(array('/orders/default/index', 't' => $payment->order->status));                
            }
        }

        /*
        Below you can see a sample successfull response of a payment process from paypal
        Array
        (
        [TOKEN] => EC-1AG000796M3683304
        [SUCCESSPAGEREDIRECTREQUESTED] => false
        [TIMESTAMP] => 2013-12-12T11:57:17Z
        [CORRELATIONID] => 89a33a155e512
        [ACK] => Success
        [VERSION] => 65.1
        [BUILD] => 8725992
        [TRANSACTIONID] => 7S255873FM437633X
        [TRANSACTIONTYPE] => expresscheckout
        [PAYMENTTYPE] => instant
        [ORDERTIME] => 2013-12-12T11:57:17Z
        [AMT] => 1800.00
        [FEEAMT] => 52.50
        [TAXAMT] => 0.00
        [CURRENCYCODE] => USD
        [PAYMENTSTATUS] => Completed
        [PENDINGREASON] => None
        [REASONCODE] => None
        [PROTECTIONELIGIBILITY] => Eligible
        [INSURANCEOPTIONSELECTED] => false
        [SHIPPINGOPTIONISDEFAULT] => false
        [PAYMENTINFO_0_TRANSACTIONID] => 7S255873FM437633X
        [PAYMENTINFO_0_TRANSACTIONTYPE] => expresscheckout
        [PAYMENTINFO_0_PAYMENTTYPE] => instant
        [PAYMENTINFO_0_ORDERTIME] => 2013-12-12T11:57:17Z
        [PAYMENTINFO_0_AMT] => 1800.00
        [PAYMENTINFO_0_FEEAMT] => 52.50
        [PAYMENTINFO_0_TAXAMT] => 0.00
        [PAYMENTINFO_0_CURRENCYCODE] => USD
        [PAYMENTINFO_0_PAYMENTSTATUS] => Completed
        [PAYMENTINFO_0_PENDINGREASON] => None
        [PAYMENTINFO_0_REASONCODE] => None
        [PAYMENTINFO_0_PROTECTIONELIGIBILITY] => Eligible
        [PAYMENTINFO_0_PROTECTIONELIGIBILITYTYPE] => ItemNotReceivedEligible,UnauthorizedPaymentEligible
        [PAYMENTINFO_0_ERRORCODE] => 0
        [PAYMENTINFO_0_ACK] => Success
        )

        */

    }
    
    
    
    public function actionPaypalCancel($payment_id) {  
        /*The user flow  wil come here when a user cancels the payment */
        /*Do what you want*/   
        $this->redirect('/site/search');
    }
}