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
        $criteria->condition = 'identity=:identity AND network=:network OR email=:email';
        $criteria->params = array(
            ':identity' => $uloginModel->identity
        , ':network' => $uloginModel->network
        ,':email' => $uloginModel->email
        );
        $user = User::model()->find($criteria);

        if (null !== $user) {
            $this->id = $user->id;
            $this->name = $user->profile->lastname.' '.$user->profile->firstname;
            $this->new_user=false;
        }
        else {
            $user = new User();
            $raw_password = $user->id.'dv.t2_aFb!!Cdg';//useless
            $user->password=md5($raw_password);
            $user->identity = $uloginModel->identity;
            $user->network = $uloginModel->network;
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
            //var_dump($this);
            //$this->isAuthenticated = true;
            //$this->redirect('/my/stage-1');
        }
        $this->isAuthenticated = true;
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