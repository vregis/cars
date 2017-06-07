<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserLogin extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;
    
	public $social_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>UserModule::t("Remember me next time"),
			'username'=>UserModule::t("username or email"),
			'password'=>UserModule::t("password"),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())  // we only want to authenticate when no input errors
		{
			$identity=new UserIdentity($this->username,$this->password);
			$identity->authenticate();
			switch($identity->errorCode)
			{
				case UserIdentity::ERROR_NONE:
					//$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
                    $duration = 3600*24*30; // 30 days
					Yii::app()->user->login($identity,$duration);
					break;
				case UserIdentity::ERROR_EMAIL_INVALID:
					$this->addError("username",UserModule::t("Email is incorrect."));
					break;
				case UserIdentity::ERROR_USERNAME_INVALID:
					$this->addError("username",UserModule::t("Username is incorrect."));
					break;
				case UserIdentity::ERROR_STATUS_NOTACTIV:
					$this->addError("status",UserModule::t("You account is not activated."));
					break;
				case UserIdentity::ERROR_STATUS_BAN:
					$this->addError("status",UserModule::t("You account is blocked."));
					break;
				case UserIdentity::ERROR_PASSWORD_INVALID:
					$this->addError("password",UserModule::t("Password is incorrect."));
					break;
			}
		}
	}
    
    
    
	public function socialLogin()
	{
        $criteria = new CDbCriteria();
        $criteria->compare('social_identity', $this->social_identity, true, 'OR');
        $criteria->compare('email', $this->username, false, 'OR');
        $user = User::model()->find($criteria);
        
        if (!empty($user)) {
            if (!stristr($user->social_identity, $this->social_identity)) {
                $soc_ids = explode(' ', $user->social_identity);
                $soc_ids[] = $this->social_identity;
                $user->social_identity = implode(' ', $soc_ids);
                $user->save();
            }
            
            $identity = new UserIdentity($this->username, 'test');
            $identity->socialLogin($user);
            
            Yii::app()->user->login($identity, 3600*24*30);
            
            $result = true;
        } else
            $result = false;
        
        return $result;
	}
    
    
    
	public function newUser($user_id, $user_email, $source, $profile_info = array())
	{
        $db_user = new User;
        $raw_password = $db_user->generatePassword();;

        $db_user->username = $user_email;
        $db_user->email=$user_email;
        $db_user->activkey = $source;
        $db_user->social_identity = $user_id;
        $db_user->createtime=time();
        $db_user->lastvisit=time();
        $db_user->superuser=0;
        $db_user->status=1;
        $r = $db_user->save();
        if (!$r) {
            CVarDumper::dump($db_user->errors, 10, true);
            exit();
        } else {
            $db_user->sendPassword($raw_password);
        }

        $db_profile = new Profile;
        $db_profile->regMode = true;
        $db_profile->user_id = $db_user->id;
        $db_profile->firstname = $profile_info['first_name'];
        $db_profile->lastname = $profile_info['last_name'];
        $db_profile->birthday = $profile_info['birthday'];
        $db_profile->gender = $profile_info['gender'];
        $db_profile->notes = $profile_info['notes'];

        if (!empty($profile_info['picture'])) {
            $img_source = file_get_contents($profile_info['picture']);

            $uname = date('YmdHis').'_'.substr(md5(uniqid(rand(), true)), 0, rand(7, 13)).'.jpg';
            $f = fopen($db_profile->sourcesPath.$uname, 'w');
            fwrite($f, $img_source);
            fclose($f);

            $db_profile->photo = $uname;
            $db_profile->savePreviews('photo');
        }

        $db_profile->save();
        
        return $raw_password;
	}
}
