<?php

class UloginWidget extends CWidget
{
    //параметры по-умолчанию
    private $params = array(
        'display'       =>  'panel',
        'fields'        =>  'first_name,last_name,email',
        'optional'      =>  '',
        'providers'     =>  'vkontakte,odnoklassniki,mailru,facebook',
        'hidden'        =>  'twitter,google,yandex,livejournal,openid,lastfm,linkedin,liveid,soundcloud,steam',
        'redirect'      =>  '',
        'logout_url'    =>  '/ulogin/logout'
    );

    public function run()
    {
        //подключаем JS скрипт
        Yii::app()->clientScript->registerScriptFile('http://ulogin.ru/js/ulogin.js', CClientScript::POS_HEAD);

        if(empty($this->params['view']))
            $this->render('uloginWidget', $this->params);
        else
            $this->render($this->params['view'], $this->params);//social synchro mode
    }

    public function setParams($params)
    {
        $this->params = array_merge($this->params, $params);
    }
}
