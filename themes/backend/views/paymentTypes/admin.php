<?php
    /* @var $this PaymentTypesController */
    /* @var $model PaymentTypes */

    $this->breadcrumbs=array(
        'Управление видами платежей',
    );

    $this->pageTitle = 'Управление видами платежей — '.Yii::app()->name;

    $this->title = 'Управление видами платежей';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление видами платежей</h5>
        
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="close-link">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
        <?php
            echo '<p class="text-right">'.CHtml::link('+ Добавить вид', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>