<?php
/* @var $this PaymentTypesController */
/* @var $model PaymentTypes */

    $this->breadcrumbs=array(
        'Управление видами платежей'=>array('admin'),
        'Редактирование вида «'.$model->name.'»',
    );

    $this->pageTitle = 'Редактирование вида «'.$model->name.'» — '.Yii::app()->name;

    $this->title = 'Управление видами платежей';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование вида «<?php echo $model->name; ?>»</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>