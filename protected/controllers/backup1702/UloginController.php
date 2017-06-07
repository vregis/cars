<?php

class UloginController extends Controller
{

    public function actionLogin() {

        if (isset($_POST['token'])) {
            $ulogin = new UloginModel();
            $ulogin->setAttributes($_POST);
            $ulogin->getAuthData();
            if ($ulogin->validate() && $ulogin->login()) {
             //   var_dump($ulogin);
              //  trace();

                //var_dump(Yii::app()->user);
                //die('____________________________________'.__FILE__);
                if($ulogin->new_user)
                    $this->redirect('/my/stage-1');
                else
                    $this->redirect(Yii::app()->user->returnUrl);
                
            }
            else {

                $this->render('error');
                //$this->redirect(Yii::app()->homeUrl);
            }
        }
        else {

            $this->redirect(Yii::app()->homeUrl, true);
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}