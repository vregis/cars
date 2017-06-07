<?php
/* @var $this PaymentsController */
/* @var $model Payments */

    $this->breadcrumbs=array(
        'Управление платежами'=>array('admin'),
        'Редактирование платежа #'.$model->id,
    );

    $this->pageTitle = 'Редактирование платежа #'.$model->id.' — '.Yii::app()->name;

    $this->title = 'Платежи';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование платежа #<?php echo $model->id; ?></h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>