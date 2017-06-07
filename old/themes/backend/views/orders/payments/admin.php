<?php
    /* @var $this PaymentsController */
    /* @var $model Payments */

    $this->breadcrumbs=array(
        'Управление платежами',
    );

    $this->pageTitle = 'Управление платежами — '.Yii::app()->name;

    $this->title = 'Платежи';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление платежами</h5>
        
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
            echo '<p class="text-right">'.CHtml::link('+ Добавить платеж', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>