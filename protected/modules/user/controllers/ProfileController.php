<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
        
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('deletePhoto', 'firstPass', 'changepassword', 'addAuthFB', 'addAuthGP', 'settings', 'edit', 'stage1', 'stage2', 'stage3', 'stage4', 'stagePublic', 'savePhoto','phone'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
        
	/**
	 * Shows a particular model.
	 */
	public function actionView($id)
	{
        $this->layout='//layouts/one_column';
        
        $model = User::model()->findByPk($id);
        if (empty($model))
            throw new CHttpException(404,'The requested page does not exist.');
            
        $profile = $model->profile;
        if (isset($_POST['User'])) {                    
            $model->attributes = $_POST['User'];
            $profile->attributes = $_POST['Profile'];

            if($model->validate() && $profile->validate()) {
                $model->save();
                $profile->save();
                Yii::app()->user->setFlash('profileMessage','Изменения сохранены.');
                
                $this->redirect(array('/user/profile/view', 'id'=>$id));
            } else 
                $profile->validate();
        } 
                
	    $this->render('view',array(
	    	'model'=>$model,
            'profile'=>$profile,
	    ));
	}

    public function actionPhone()
    {
        $phone='';
        if(isset($_POST['owner_id'])){
            $ph =  Profile::phoneByID($_POST['owner_id']);
            $phone=trim($ph[0]->public_phone.' '.$ph[0]->alter_phone);
        }
        IF(empty($phone))$phone='no phone';
        echo  trim($phone);
    }


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
        $this->redirect(array('/user/profile/stage1'));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionFirstPass($p)
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
		$model = new UserChangePassword;
        $user = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        
		if (Yii::app()->user->id) {				
			if(isset($_POST['UserChangePassword'])) {
                $model->attributes = $_POST['UserChangePassword'];
                $model->oldPassword = 'tmp';

                if ($model->validate() && ($user->password == $p)) {
                    $new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
                    $new_password->password = UserModule::encrypting($model->password);
                    $new_password->activkey=UserModule::encrypting(microtime().$model->password);
                    $new_password->save();
                    
                    Yii::app()->user->setFlash('profileMessage','Новый пароль сохранен.');
                    $this->redirect(array("stage1"));
                } elseif (empty($model->errors) && ($user->password != md5($model->oldPassword)))
                    $model->addError('oldPassword', Yii::t('app', 'Old password incorrect.'));
			}
            
			$this->render('changepassword',array('model'=>$model, 'user'=>$user));
	    }
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionStage1()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = $this->loadUser();
        $profile = $model->profile;      
        
        if ($model->id != Yii::app()->user->id)
            throw new CHttpException(404, 'The requested page does not exist.');        

        if (isset($_POST['User']) || isset($_POST['Profile']))
        {                    
            if (isset($_POST['User']))
                $model->attributes=$_POST['User'];
            
            if (isset($_POST['Profile']))
                $profile->attributes=$_POST['Profile'];
            
            if (is_array($profile->languages))
                $profile->languages = implode(',',$profile->languages);

            if ($model->validate()&&$profile->validate()) {
                $model->save();
                $profile->save();
                Yii::app()->user->setFlash('profileMessage','Изменения сохранены.');
                
                if ($model->first_complete == 0) {
                    $model->first_complete = 1;
                    $model->save();
                    
                    $this->redirect(array('/user/profile/stage2'));
                } else
                    $this->redirect(array('/user/profile/stage1'));
            } else $profile->validate();
        }   
            
        if (!is_array($profile->languages))
            $profile->languages = explode(',',$profile->languages);         
        

        //define nit synchronized social account yet
        $user = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        $ar0=explode(',','vkontakte,odnoklassniki,mailru,facebook,twitter,google,yandex,livejournal,openid,lastfm,linkedin,liveid,soundcloud,steam');

        $ar1=explode(' ',  $user->social_identity);
        $ar0=array_diff($ar0, $ar1);
        $providers=implode(',',array_slice($ar0, 0,4));
        $hidden=implode(',',array_slice($ar0, 4));
        $uparams = array(
        'display'       =>  'panel',
        'fields'        =>  'first_name,last_name,email',
        'optional'      =>  '',
        'providers'     =>  $providers,
        'hidden'        =>  $hidden,
        'redirect'      =>  'http://'.$_SERVER['HTTP_HOST'].'/index.php?r=ulogin/synchro',
        'view'          =>  'uloginWidgetSyn',
        'logout_url'    =>  '/ulogin/logout',
        );

        $this->render('stage1',array(
            'model'=>$model,
            'profile'=>$profile,
            'uparams'=>$uparams,
        ));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionStage2()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = $this->loadUser();
        $profile = $model->profile;      
        
        if ($model->id != Yii::app()->user->id) throw new CHttpException(404, 'The requested page does not exist.');        
        if ($model->first_complete < 1) $this->redirect(array('/user/profile/stage1'));   
                
        $userDocument = new UserDocuments;
        $userDocument->user_id = Yii::app()->user->id;  
        
        $userDocumentModel=new UserDocuments('frontendSearch');
        $userDocumentModel->unsetAttributes();    

        if (isset($_POST['Profile']))
        {                    
            $profile->attributes = $_POST['Profile'];

            if ($profile->validate()) {
                $profile->save();
                Yii::app()->user->setFlash('profileMessage','Изменения сохранены.');
                
                if(isset($_POST['UserDocuments'])) {
                    $userDocument->title = $_POST['UserDocuments']['title'];
                    $userDocument->save();
                }
                
                if ($model->first_complete == 1) {
                    $model->first_complete = 2;
                    $model->save();
                    
                    $this->redirect(array('/user/profile/stage3'));
                } else
                    $this->redirect(array('/user/profile/stage2'));
            } else $profile->validate();
        }       

        $this->render('stage2',array(
            'model'=>$model,
            'profile'=>$profile,
            'userDocument'=>$userDocument,
            'userDocumentModel'=>$userDocumentModel,
        ));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionSavePhoto($type)
	{        
        $model = $this->loadUser();
        $profile = $model->profile;      
        
        if ($model->id != Yii::app()->user->id) throw new CHttpException(404, 'The requested page does not exist.');        
        if ($model->first_complete < 1) return false;   
        if (!in_array($type, array('photo', 'photo2', 'photo3'))) return false;
        
        if (isset($_POST['Profile']))
        {   
            $profile->$type = $_POST['Profile'][$type];

            if ($profile->validate()) {
                $profile->save();
            }
        }    
        
        if (!empty($profile->$type))
            echo $profile->getSquarePhoto($type);
        
        return true;
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionStage3()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = $this->loadUser();
        $profile = $model->profile;      
        
        if ($model->id != Yii::app()->user->id) throw new CHttpException(404, 'The requested page does not exist.');        
        if ($model->first_complete < 2) $this->redirect(array('/user/profile/stage2'));        
        
        if (isset($_POST['Profile']))
        {                    
            $profile->attributes=$_POST['Profile'];

            if($model->validate()&&$profile->validate()) {
                $model->save();
                $profile->save();
                Yii::app()->user->setFlash('profileMessage','Изменения сохранены.');
                
                if ($model->first_complete == 2) {
                    $model->first_complete = 3;
                    $model->save();
                    
                    $this->redirect(array('/user/profile/stage4'));
                } else
                    $this->redirect(array('/user/profile/stage3'));
            } else $profile->validate();
        }          

        $this->render('stage3',array(
            'model'=>$model,
            'profile'=>$profile,
        ));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionStage4()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = $this->loadUser();
        $profile = $model->profile;      
        
        if ($model->id != Yii::app()->user->id) throw new CHttpException(404, 'The requested page does not exist.');        
        if ($model->first_complete < 3) $this->redirect(array('/user/profile/stage3'));

        $this->render('stage4',array(
            'model'=>$model,
            'profile'=>$profile,
        ));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionStagePublic()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = $this->loadUser();
        $profile = $model->profile;      

        $this->render('stage_public',array(
            'model'=>$model,
            'profile'=>$profile,
        ));
	}

	/**
	 * Login via Facebook
	 */
	public function actionAddAuthFB()
	{
        require_once dirname(__FILE__).'/../../../extensions/Facebook/autoload.php';
        
        $fb = new Facebook\Facebook([
            'app_id' => Yii::app()->params['facebook']['appID'],
            'app_secret' => Yii::app()->params['facebook']['secret'],
            'default_graph_version' => 'v2.2',
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
       
        $user_id = $user->getField('id');
        $user_email = $user->getField('email');

        //if ($this->userModel->username == $user_email || $this->userModel->email == $user_email) {
            $current_user = User::model()->findByPk(Yii::app()->user->id);
            $profile = $current_user->profile;

            $criteria = new CDbCriteria();
            $criteria->compare('social_identity', $user_id, true);
            $existing_user = User::model()->find($criteria);
            
            if (empty($existing_user) && !empty($current_user) && !stristr($current_user->social_identity, $user_id)) {
                if (empty($profile->firstname)) $profile->firstname = $user->getField('first_name');
                if (empty($profile->lastname)) $profile->lastname = $user->getField('last_name');
                if (empty($profile->birthday)) $profile->birthday = $user->getField('birthday');
                if (empty($profile->gender)) $profile->gender = (($user->getField('gender') == 'male')?(0):(1));
                if (empty($profile->notes)) $profile->notes = $user->getField('about');
                
                if (empty($profile->photo) && !empty($user->getField('picture')->getField('url'))) {
                    $img_source = file_get_contents($user->getField('picture')->getField('url'));

                    $uname = date('YmdHis').'_'.substr(md5(uniqid(rand(), true)), 0, rand(7, 13)).'.jpg';
                    $f = fopen($profile->sourcesPath.$uname, 'w');
                    fwrite($f, $img_source);
                    fclose($f);

                    $profile->photo = $uname;
                    $profile->savePreviews('photo');
                }
                        
                $current_user->social_identity .= ' FB'.$user_id;
                $profile->save();
                $current_user->save();
            }
        //}
        
        $this->redirect(array('/user/profile/stage1'));
	}

	/**
	 * Login via Google+
	 */
	public function actionAddAuthGP()
	{     
        $client = new Google_Client;
        $client->setClientId(Yii::app()->params['GoogleAuth']['clientID']);
        $client->setClientSecret(Yii::app()->params['GoogleAuth']['clientSecret']);
        $client->setRedirectUri(Yii::app()->createAbsoluteUrl('/user/profile/addAuthGP'));
        $client->addScope("email");
        $client->addScope("profile");
        
        $service = new Google_Service_Oauth2($client);
        
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            header('Location: ' . filter_var(Yii::app()->createAbsoluteUrl('/user/profile/addAuthGP'), FILTER_SANITIZE_URL));
            exit;
        }
        
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            
            $user = $service->userinfo->get(); //get user info 
    
            //if ($this->userModel->username == $user->email || $this->userModel->email == $user->email) {
                $current_user = User::model()->findByPk(Yii::app()->user->id);
                $profile = $current_user->profile;

                $criteria = new CDbCriteria();
                $criteria->compare('social_identity', 'GP'.$user->id, true);
                $existing_user = User::model()->find($criteria);
                
                if (empty($existing_user) && !empty($current_user) && !stristr($current_user->social_identity, $user->id)) {
                    if (empty($profile->firstname)) $profile->firstname = $user->givenName;
                    if (empty($profile->lastname)) $profile->lastname = $user->familyName;
                    if (empty($profile->gender)) $profile->gender = (($user->gender == 'male')?(0):(1));
                
                    if (empty($profile->photo) && !empty($user->picture)) {
                        $img_source = file_get_contents($user->picture);

                        $uname = date('YmdHis').'_'.substr(md5(uniqid(rand(), true)), 0, rand(7, 13)).'.jpg';
                        $f = fopen($profile->sourcesPath.$uname, 'w');
                        fwrite($f, $img_source);
                        fclose($f);

                        $profile->photo = $uname;
                        $profile->savePreviews('photo');
                    }
                
                    $current_user->social_identity .= ' GP'.$user->id;
                    $profile->save();
                    $current_user->save();
                }
            //}

            $this->redirect(array('/user/profile/stage1'));
        }
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionDeletePhoto($t)
	{
        if (!in_array($t, array(0, 1, 2))) return false;
        
        $profile = Profile::model()->findByAttributes(array('user_id' => Yii::app()->user->id));
        if (!empty($profile)) {
            switch ($t) {
                case 0: $profile->photo = NULL; $profile->removeImages('photo'); break;
                case 1: $profile->photo2 = NULL; $profile->removeImages('photo2'); break;
                case 2: $profile->photo3 = NULL; $profile->removeImages('photo3'); break;
            }
            
            $profile->save();
        }
        
        $this->redirect(array("stage2"));
	}


    
	public function actionSettings()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $r = false;
        
        if (isset($_POST['language-change-control'])) {
            Yii::app()->language = $_POST['language-change-control'];
            Yii::app()->user->setState('language', $_POST['language-change-control']); 
            $cookie = new CHttpCookie('language', $_POST['language-change-control']);
            $cookie->expire = time() + (60*60*24*365); // (1 year)
            Yii::app()->request->cookies['language'] = $cookie;
            
            $r = true;
        }
        
        if (isset($_POST['currency-change-control'])) {
            Currencies::apply($_POST['currency-change-control']);
            
            $r = true;
        }
        
        if ($r)
            $this->redirect(array('/user/profile/settings'));
        
        $this->render('settings',array(
        ));
	}
    
    
    
	/**
	 * Change password
	 */
	public function actionChangepassword() 
    {
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
		$model = new UserChangePassword;
        $user = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        
		if (Yii::app()->user->id) {			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
                $model->attributes = $_POST['UserChangePassword'];

                if ($model->validate() && ($user->password == md5($model->oldPassword))) {
                    $new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
                    $new_password->password = UserModule::encrypting($model->password);
                    $new_password->activkey=UserModule::encrypting(microtime().$model->password);
                    $new_password->save();
                    
                    Yii::app()->user->setFlash('profileMessage','Новый пароль сохранен.');
                    $this->redirect(array("stage1"));
                } elseif (empty($model->errors) && ($user->password != md5($model->oldPassword)))
                    $model->addError('oldPassword', Yii::t('app', 'Old password incorrect.'));
			}
            
			$this->render('changepassword',array('model'=>$model, 'user'=>$user));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}
}