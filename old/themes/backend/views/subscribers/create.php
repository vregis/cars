<?php
/* @var $this SubscribersController */
/* @var $model Subscribers */

    $this->breadcrumbs=array(
        'Управление подписчиками'=>array('admin'),
        'Добавление подписчика',
    );

    $this->pageTitle = 'Добавление подписчика — '.Yii::app()->name;

    $this->title = 'Подписчики';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление подписчика</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


