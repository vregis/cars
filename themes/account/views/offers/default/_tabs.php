<?php
    $tab_menu = array(
        array(
            'label' => Yii::t('app', 'General'),
            'url' => array('/offers/default/edit', 'id' => $model->id),
        ),
        /*array(
            'label' => Yii::t('app', 'Blocking'),
            'url' => array('/offers/offerBlocks/index', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'offerBlocks'),
        ),*/
        /*array(
            'label' => Yii::t('app', 'Parameters').' ('.count($model->parameters).')',
            'url' => array('/offers/offersParameterValues/index', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'offersParameterValues'),
        ),*/
        array(
            'label' => Yii::t('app', 'Photos').' ('.count($model->photos).')',
            'url' => array('/offers/offerPhotos/index', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'offerPhotos'),
        ),
        array(
            'label' => Yii::t('app', 'Prices').' ('.count($model->options).')',
            'url' => array('/offers/offerOptions/index', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'offerOptions'),
        ),
        /*array(
            'label' => Yii::t('app', 'Documents').' ('.count($model->documents).')',
            'url' => array('/offers/offerDocuments/index', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'offerDocuments'),
        ),*/
        array(
            'label' => Yii::t('app', 'FAQ').' ('.count($model->faq).')',
            'url' => array('/offers/offerFaq/index', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'offerFaq'),
        ),
    );

    $this->widget('zii.widgets.CMenu',array(
        'encodeLabel'=>false,
        'items'=>$tab_menu,
        'htmlOptions' => array(
            'class' => 'nav nav-tabs small-tabs'
        ),
    ));  