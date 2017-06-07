<?php
class loginGWidget extends CWidget
{    
    public $redirectUrl = '/user/login/socialGP';
    
    public $label = 'Sign in with Google+';
    
	public function init()
	{
        //require_once dirname(__FILE__) . '/autoload.php';
	}
    

	public function run()
	{          
        $client = new Google_Client;
        $client->setClientId(Yii::app()->params['GoogleAuth']['clientID']);
        $client->setClientSecret(Yii::app()->params['GoogleAuth']['clientSecret']);
        $client->setRedirectUri(Yii::app()->createAbsoluteUrl($this->redirectUrl));
        $client->addScope("email");
        $client->addScope("profile");

        echo CHtml::link('<i class="fa fa-google-plus"></i>'.Yii::t('app', $this->label), $client->createAuthUrl(), array('class' => 'btn btn-google'));
    }
}