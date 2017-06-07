<?php
/* @var $this OfferAddressesController */
/* @var $model OfferAddresses */

    $this->breadcrumbs=array(
        'Управление пользователями'=>array('/user/admin/admin'),
        $model->user->profile->name=>array('/user/admin/update', 'id'=>$model->user_id),
        'Управление адресами'=>array('/user/userAddresses/admin', 'id'=>$model->user_id),
        'Добавление адреса',
    );

    $this->pageTitle = 'Добавление адреса — '.Yii::app()->name;

    $this->title = 'Пользователи';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/admin/_tabs', array('model'=>$model->user)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Добавление адреса</h3>
                <br />
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>