<?php

return array(
    'bot' => array(
        'id' => 1
    ),
    
    //'PAYPAL_API_USERNAME'=>'mailbox-facilitator_api1.vkomlev.ru',
    //'PAYPAL_API_PASSWORD'=>'1383561162',
    //'PAYPAL_API_SIGNATURE'=>'AFcWxV21C7fd0v3bYYYRCpSSRl31AGLXbqfA2udGAXNLt7SNiYxVIvbT',
    'PAYPAL_MODE'=>'live',   // sandbox/live  default=sandbox 
    
    'adminEmail'=>'mailbox@vkomlev.ru',
    'adminName'=>'Администратор сайта',
    'publicEmail'=>'mailbox@vkomlev.ru',
    'publicName'=>'Club Webmaster',

    'GooglePlacesAPI' => 'AIzaSyCkh9gLYt6__lvVCe-ewWTXD78DTChTLCM',
    'GoogleAuth' => array(
        'clientID' => '462414470934-aejog5nu6m2810mg1sdtkh2g8bkb5si9.apps.googleusercontent.com',
        'clientSecret' => '45Fx4GpiOY6BzjAacY8Wbpcm',
    ),
    
    'facebook' => array(
        'appID' => '1683721048549341',
        'secret' => '285cc5e518602938aee36dcad6994de9',
    ),

    'base_currency' => array(
        'id' => '1',
        'name' => 'USD',
        'template' => '$%num%',
        'rate' => 1,
    ),

    'currency'=>array(
        'id' => '1',
        'name' => 'USD',
        'template' => '$%num%',
        'rate' => 1,
    ),

    'languages'=>array(
        'en' => 'English',
        'de' => 'Deutsch',
        'es' => 'עברית',
        'ru' => 'Русский',
    ),

    'transliteration_url'=>'http://lab.vkomlev.ru/transliteration/',

    'YiiMailer' => array(
        'viewPath' => 'application.views.mail',
        'layoutPath' => 'application.views.layouts',
        'baseDirPath' => 'webroot.images.mail',
        'savePath' => 'webroot.assets.mail',
        'testMode' => false,
        'UseSendmailOptions' => true,
        'layout' => 'mail',
        'CharSet' => 'UTF-8',
        'AltBody' => Yii::t('YiiMailer','You need an HTML capable viewer to read this message.'),
        'language' => array(
            'authenticate'         => Yii::t('YiiMailer','SMTP Error: Could not authenticate.'),
            'connect_host'         => Yii::t('YiiMailer','SMTP Error: Could not connect to SMTP host.'),
            'data_not_accepted'    => Yii::t('YiiMailer','SMTP Error: Data not accepted.'),
            'empty_message'        => Yii::t('YiiMailer','Message body empty'),
            'encoding'             => Yii::t('YiiMailer','Unknown encoding: '),
            'execute'              => Yii::t('YiiMailer','Could not execute: '),
            'file_access'          => Yii::t('YiiMailer','Could not access file: '),
            'file_open'            => Yii::t('YiiMailer','File Error: Could not open file: '),
            'from_failed'          => Yii::t('YiiMailer','The following From address failed: '),
            'instantiate'          => Yii::t('YiiMailer','Could not instantiate mail function.'),
            'invalid_address'      => Yii::t('YiiMailer','Invalid address'),
            'mailer_not_supported' => Yii::t('YiiMailer',' mailer is not supported.'),
            'provide_address'      => Yii::t('YiiMailer','You must provide at least one recipient email address.'),
            'recipients_failed'    => Yii::t('YiiMailer','SMTP Error: The following recipients failed: '),
            'signing'              => Yii::t('YiiMailer','Signing Error: '),
            'smtp_connect_failed'  => Yii::t('YiiMailer','SMTP Connect() failed.'),
            'smtp_error'           => Yii::t('YiiMailer','SMTP server error: '),
            'variable_set'         => Yii::t('YiiMailer','Cannot set or reset variable: ')
        ),
    )
);