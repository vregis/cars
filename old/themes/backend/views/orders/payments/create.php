<?php
/* @var $this PaymentsController */
/* @var $model Payments */

    $this->breadcrumbs=array(
        'Управление платежами'=>array('admin'),
        'Добавление платежа',
    );

    $this->pageTitle = 'Добавление платежа — '.Yii::app()->name;

    $this->title = 'Платежи';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление платежа</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


