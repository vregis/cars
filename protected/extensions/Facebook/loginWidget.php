<?php
class loginWidget extends CWidget
{    
    public $redirectUrl = '/user/login/socialFB';
    
    public $label = 'Continue with Facebook';
    
	public function init()
	{
        require_once dirname(__FILE__) . '/autoload.php';
	}
    

	public function run()
	{  
        $fb = new Facebook\Facebook([
            'app_id' => Yii::app()->params['facebook']['appID'],
            'app_secret' => Yii::app()->params['facebook']['secret'],
            'default_graph_version' => 'v2.7',
            'persistent_data_handler'=>'session'
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(Yii::app()->createAbsoluteUrl($this->redirectUrl), $permissions);

        echo CHtml::link('<i class="fa fa-facebook"></i>'.Yii::t('app', $this->label), $loginUrl, array('class' => 'btn btn-facebook'));
    }
}