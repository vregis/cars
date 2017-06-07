<?php
/* @var $data Currencies */

    if (Yii::app()->params['currency']['id'] != $data->id)
        $suffix = '<br />[&nbsp;'.CHtml::link(Yii::t('app', 'Use it'), array('/site/currencies', 'currency_change' => $data->id)).'&nbsp;]';
    else 
        $suffix = '<br />&mdash;&nbsp;<strong>'.Yii::t('app', 'Used now').'</strong>';

    echo $data->fullName.$suffix.'<br /><br />';