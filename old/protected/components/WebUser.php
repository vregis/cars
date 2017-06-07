<?php
class WebUser extends CWebUser {
    private $_model = null;
 
    static private $_admins;
    static private $_publishers;
    static private $_editors;
    static private $_conductors;
    static private $_singers;
    static private $_bloggers;
    
    function getRole() {
        if($user = $this->getModel()){
            // в таблице User есть поле role
            return $user->role;
        }
    }
 
    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = User::model()->findByPk($this->id, array('select' => 'role'));
        }
        return $this->_model;
    }

    /**
     * Return admins.
     * @return array syperusers names
     */	
    public function getAdmins() {
        if (!self::$_admins) {
                $admins = User::model()->active()->superuser()->findAll();
                $return_name = array();
                foreach ($admins as $admin)
                        array_push($return_name,$admin->username);
                self::$_admins = $return_name;
        }
        return self::$_admins;
    }

    /**
     * Return is current user admin or not.
     * @return boolean
     */	
    public function isAdmin() {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (empty($user))
            return false;
        else
            return ($user->superuser == 3);
    }

    
    
    public function getPublishers() {
        if (!self::$_publishers) {
                $publishers = User::model()->active()->publisher()->findAll();
                $return_name = array();
                foreach ($publishers as $publisher)
                        array_push($return_name,$publisher->username);
                self::$_publishers = $return_name;
        }
        return self::$_publishers;
    }


    
    public function isPublisher() {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (empty($user))
            return false;
        else
            return ($user->superuser == 2);
    }


    
    public function getEditors() {
        if (!self::$_editors) {
                $editors = User::model()->active()->editor()->findAll();
                $return_name = array();
                foreach ($editors as $editor)
                        array_push($return_name,$editor->username);
                self::$_editors = $return_name;
        }
        return self::$_editors;
    }


    
    public function isEditor() {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (empty($user))
            return false;
        else
            return ($user->superuser == 4);
    }


    
    public function getConductors() {
        if (!self::$_conductors) {
                $conductors = User::model()->active()->conductor()->findAll();
                $return_name = array();
                foreach ($conductors as $conductor)
                        array_push($return_name,$conductor->username);
                self::$_conductors = $return_name;
        }
        return self::$_conductors;
    }


    
    public function isConductor() {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (empty($user))
            return false;
        else
            return ($user->superuser == 1);
    }


    
    public function getSingers() {
        if (!self::$_singers) {
                $singers = User::model()->active()->singer()->findAll();
                $return_name = array();
                foreach ($singers as $singer)
                        array_push($return_name,$singer->username);
                self::$_singers = $return_name;
        }
        return self::$_singers;
    }


    
    public function isSinger() {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (empty($user))
            return false;
        else
            return ($user->superuser == 0);
    }


    
    public function getBloggers() {
        if (!self::$_bloggers) {
                $bloggers = User::model()->active()->blogger()->findAll();
                $return_name = array();
                foreach ($bloggers as $blogger)
                        array_push($return_name,$blogger->username);
                self::$_bloggers = $return_name;
        }
        return self::$_bloggers;
    }


    
    public function isBlogger() {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (empty($user))
            return false;
        else
            return ($user->superuser == 3);
    }
}