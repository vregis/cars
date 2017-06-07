<?php
/* @var $data Currencies */

    if (Yii::app()->language != $code) {
        $params = $_GET;
        $params['language'] = $code;

        $suffix = '<br />[&nbsp;'.CHtml::link(Yii::t('Use it'), array_merge(array($this->id.'/'.$this->action->id), $params)).'&nbsp;]';
    } else 
        $suffix = '<br />&mdash;&nbsp;<strong>'.Yii::t('Used now').'</strong>';

    echo CHtml::image(Yii::app()->theme->baseUrl.'/img/flags/'.$code.'.png', $code).'&nbsp;'.$name.$suffix.'<br /><br />';