<?php

class MailForms {
    function sendNotification($title, $message, $recepient = NULL) {
        $mail = new YiiMailer('notification', array(
            'message' => $message
        ));
        
        if (empty($recepient))
            $recepient = Yii::app()->params['adminEmail'];

        $mail->setFrom(Yii::app()->params['adminEmail'], Yii::app()->params['adminName']);
        $mail->setTo($recepient);
        $mail->setSubject($title);

        $result = $mail->send();
        
        return $result;
    }
    
    
    function sendInformation($title, $message, $recepient) {
        $mail = new YiiMailer('information', array(
            'message' => $message
        ));
        
        if (empty($recepient))
            $recepient = Yii::app()->params['adminEmail'];

        $mail->setFrom(Yii::app()->params['publicEmail'], Yii::app()->params['publicName']);
        $mail->setTo($recepient);
        $mail->setSubject($title);

        $result = $mail->send();
        
        return $result;
    }
}