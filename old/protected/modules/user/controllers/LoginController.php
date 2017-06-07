<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        Yii::app()->theme = 'frontend';
        $this->layout='//layouts/one_column';

		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if ($model->validate()) {
					$this->lastViset();
					if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				} else
                    Yii::app()->user->setFlash('loginMessage',UserModule::t("Thank you for your registration. Please check your email."));
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}

	/**
	 * Login via Facebook
	 */
	public function actionSocialFB()
	{
        require_once dirname(__FILE__).'/../../../extensions/Facebook/autoload.php';
        
        $fb = new Facebook\Facebook([
            'app_id' => Yii::app()->params['facebook']['appID'],
            'app_secret' => Yii::app()->params['facebook']['secret'],
            'default_graph_version' => 'v2.7',
            'persistent_data_handler'=>'session'
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            
            exit;
        }

        // Logged in.
        $oAuth2Client = $fb->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        try {
            $response = $fb->get('/me?fields=id,email,first_name,last_name,gender,picture.width(800),about', $accessToken);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $user = $response->getGraphUser();
       
        $user_id = 'FB'.$user->getField('id');
        $user_email = $user->getField('email');
        
        $model = new UserLogin;
        $model->username = $user_email;
        $model->social_identity = $user_id;

        if ($model->socialLogin()) {
            $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
            $lastVisit->lastvisit = time();
            $lastVisit->save();

            /*if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
                $this->redirect(Yii::app()->getModule('user')->returnUrl);
            else
                $this->redirect(Yii::app()->user->returnUrl);*/
            $this->redirect(Yii::app()->controller->module->returnUrl);
        } else {
            $criteria = new CDbCriteria();
            $criteria->compare('social_identity', $user_id, true);
            $existing_user = User::model()->find($criteria);
            
            if (empty($existing_user)) {
                $profile_info = array(
                    'first_name' => $user->getField('first_name'),
                    'last_name' => $user->getField('last_name'),
                    'birthday' => $user->getField('birthday'),
                    'gender' => (($user->getField('gender') == 'male')?(0):(1)),
                    'notes' => $user->getField('about'),
                    'picture' => $user->getField('picture')->getField('url'),
                );

                $raw_password = UserLogin::newUser($user_id, $user_email, 'facebook', $profile_info);

                $model->username = $user_email;
                $model->password = $raw_password;

                if ($model->validate())
                    $this->redirect(array('/user/profile/firstPass', 'p' => md5($raw_password)));
            } else
                $model->addError('social_identity', Yii::t('app', 'This Social ID is already used.'));
        }

        if (! $accessToken->isLongLived()) {
        // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                exit;
            }

            echo '<h3>Long-lived</h3>';
            CVarDumper::dump($accessToken->getValue(), 10, true);
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;
	}

	/**
	 * Login via Google+
	 */
	public function actionSocialGP()
	{     
        $client = new Google_Client;
        $client->setClientId(Yii::app()->params['GoogleAuth']['clientID']);
        $client->setClientSecret(Yii::app()->params['GoogleAuth']['clientSecret']);
        $client->setRedirectUri(Yii::app()->createAbsoluteUrl('/user/login/socialGP'));
        $client->addScope("email");
        $client->addScope("profile");
        
        $service = new Google_Service_Oauth2($client);
        
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            header('Location: ' . filter_var(Yii::app()->createAbsoluteUrl('/user/login/socialGP'), FILTER_SANITIZE_URL));
            exit;
        }
        
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            
            $user = $service->userinfo->get(); //get user info 
    
            $model = new UserLogin;
            $model->username = $user->email;
            $model->social_identity = 'GP'.$user->id;

            if ($model->socialLogin()) {
                $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
                $lastVisit->lastvisit = time();
                $lastVisit->save();

                /*if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
                    $this->redirect(Yii::app()->getModule('user')->returnUrl);
                else
                    $this->redirect(Yii::app()->user->returnUrl);*/
                $this->redirect(Yii::app()->controller->module->returnUrl);
            } else {
                $criteria = new CDbCriteria();
                $criteria->compare('social_identity', 'GP'.$user->id, true);
                $existing_user = User::model()->find($criteria);

                if (empty($existing_user)) {
                    $profile_info = array(
                        'first_name' => $user->givenName,
                        'last_name' => $user->familyName,
                        'birthday' => date('Y-m-d'),
                        'gender' => (($user->gender == 'male')?(0):(1)),
                        'notes' => '',
                        'picture' => $user->picture,
                    );

                    $raw_password = UserLogin::newUser('GP'.$user->id, $user->email, 'google', $profile_info);

                    $model->username = $user->email;
                    $model->password = $raw_password;

                    if ($model->validate()) 
                        $this->redirect(array('/user/profile/firstPass', 'p' => md5($raw_password)));
                } else
                    $model->addError('social_identity', Yii::t('app', 'This Social ID is already used.'));
            }
        }
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}