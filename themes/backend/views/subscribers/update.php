<?php
/* @var $this SubscribersController */
/* @var $model Subscribers */

    $this->breadcrumbs=array(
        'Управление подписчиками'=>array('admin'),
        'Редактирование подписчика «'.$model->email.'»',
    );

    $this->pageTitle = 'Редактирование подписчика «'.$model->email.'» — '.Yii::app()->name;

    $this->title = 'Подписчики';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование подписчика «<?php echo $model->email; ?>»</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>