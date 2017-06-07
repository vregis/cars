<?php
/* @var $this PaymentTypesController */
/* @var $model PaymentTypes */

    $this->breadcrumbs=array(
        'Управление видами платежей'=>array('admin'),
        'Добавление вида',
    );

    $this->pageTitle = 'Добавление вида — '.Yii::app()->name;

    $this->title = 'Управление видами платежей';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление вида</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


