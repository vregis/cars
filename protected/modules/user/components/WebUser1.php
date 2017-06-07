<?php
class WebUser1 extends CWebUser {
    private $_model = null;
 
    static private $_admins;
    
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
     * @return boolean is current user admin or not
     */	
    public function isAdmin() {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (empty($user))
            return false;
        else
            return ($user->superuser == 1);
    }
}