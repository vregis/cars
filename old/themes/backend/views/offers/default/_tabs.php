<?php
    $tab_menu = array(
        array(
            'label' => 'Общее',
            'url' => array('/offers/default/update', 'id' => $model->id),
        ),
        array(
            'label' => 'Параметры ('.count($model->parameters).')',
            'url' => array('/offers/offersParameterValues/admin', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'offersParameterValues'),
        ),
        array(
            'label' => 'Комментарии ('.count($model->comments).')',
            'url' => array('/offers/offerComments/admin', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'offerComments'),
        ),
        array(
            'label' => 'Отзывы ('.count($model->reviews).')',
            'url' => array('/offers/offerReviews/admin', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'offerReviews' || Yii::app()->controller->id == 'offerReviewPhotos'),
        ),
        array(
            'label' => 'Вопросы ('.count($model->faq).')',
            'url' => array('/offers/offerFaq/admin', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'offerFaq'),
        ),
        array(
            'label' => 'Опции ('.count($model->options).')',
            'url' => array('/offers/offerOptions/admin', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'offerOptions'),
        ),
        array(
            'label' => 'Фотографии ('.count($model->photos).')',
            'url' => array('/offers/offerPhotos/admin', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'offerPhotos'),
        ),
        array(
            'label' => 'Документы ('.count($model->documents).')',
            'url' => array('/offers/offerDocuments/admin', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'offerDocuments'),
        ),
    );

    $this->widget('zii.widgets.CMenu',array(
        'encodeLabel'=>false,
        'items'=>$tab_menu,
        'htmlOptions' => array(
            'class' => 'nav nav-tabs'
        ),
    ));  