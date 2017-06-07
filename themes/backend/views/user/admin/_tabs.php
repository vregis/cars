<?php
    $tab_menu = array(
        array(
            'label' => 'Общее',
            'url' => array('/user/admin/update', 'id' => $model->id),
        ),
        array(
            'label' => 'Адреса ('.count($model->addresses).')',
            'url' => array('/user/userAddresses/admin', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'userAddresses'),
        ),
        array(
            'label' => 'Документы ('.count($model->documents).')',
            'url' => array('/user/userDocuments/admin', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'userDocuments'),
        ),
        array(
            'label' => 'Избранное ('.count($model->favourites).')',
            'url' => array('/user/userFavourites/admin', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'userFavourites'),
        ),
        array(
            'label' => 'Отзывы ('.count($model->reviews).')',
            'url' => array('/user/userReviews/admin', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'userReviews' || Yii::app()->controller->id == 'userReviewsMarks'),
        ),
        array(
            'label' => 'Уведомления ('.count($model->notifications).')',
            'url' => array('/user/notifications/admin', 'id' => $model->id),
            'active' => (Yii::app()->controller->id == 'notifications'),
        ),
    );

    $this->widget('zii.widgets.CMenu',array(
        'encodeLabel'=>false,
        'items'=>$tab_menu,
        'htmlOptions' => array(
            'class' => 'nav nav-tabs'
        ),
    ));  