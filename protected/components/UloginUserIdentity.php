<?php

class UloginUserIdentity implements IUserIdentity
{

    private $id;
    private $name;
    private $isAuthenticated = false;
    private $states = array();
    private $new_user=false;

    public function __construct()
    {
    }

    public function authenticate($uloginModel = null)
    {

        $criteria = new CDbCriteria;
        $criteria->condition = 'social_identity LIKE :social_identity OR email=:email';
        $criteria->params = array(
            ':social_identity' => '%'.$uloginModel->network.' '.$uloginModel->identity.'%',
            ':email' => $uloginModel->email
        );
        $user = User::model()->find($criteria);

        if (null !== $user) { //user exists
            $this->id = $user->id;
            $this->name = $user->profile->lastname.' '.$user->profile->firstname;
            $this->new_user=false;
        }
        else {
            $user = new User();
            //Check password
            $raw_password = 'dv.t2_aFb!!Cdg';//useless
            $user->password=md5($raw_password);
            if(!empty($user->social_identity))$user->social_identity.=' ';
            $user->social_identity .= $uloginModel->network.' '.$uloginModel->identity;
            
            $user->email = $uloginModel->email;
            $user->status = 1;
            $user->username = $uloginModel->network.'_'.$uloginModel->identity;//useless
            $user->save();

            $this->id = $user->id;
            $db_profile = new Profile;
            $db_profile->user_id = $user->id;
            $db_profile->firstname = $uloginModel->full_name;
            $db_profile->save();
            $this->name = $user->profile->firstname;
            $this->new_user=true;
        }
        $this->isAuthenticated = true;
        return true;
    }

    public function synchronize($uloginModel = null)
    {

        $criteria = new CDbCriteria;
        $criteria->condition = 'social_identity LIKE :social_identity';
        $criteria->params = array(
          //  ':social_identity' => '%'.$uloginModel->network.' '.$uloginModel->identity.'%',
             ':social_identity' => '%'.$uloginModel->network.'%',
        );
        $user = User::model()->find($criteria);
        //var_dump($user);
        //die('all');
        if (null !== $user) { //user exists
            return false;
        }
        else { 
            $user_id=Yii::app()->user->id;
            if(empty($user_id))
                return false;
            $user = User::model()->findByPk($user_id);
                
            if(!empty($user->social_identity))$user->social_identity.=' ';
            $user->social_identity .= $uloginModel->network.' '.$uloginModel->identity;           
            $user->save();
        }
        return true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIsAuthenticated()
    {
        return $this->isAuthenticated;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPersistentStates()
    {
        return $this->states;
    }
    public function getNewUser()
    {
        return $this->new_user;
    }
}