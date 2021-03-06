<?php
/* @var $this StaticPagesController */
/* @var $model StaticPages */

    $this->breadcrumbs=array(
        'Параметры сайта',
    );

    $this->pageTitle = 'Параметры сайта — '.Yii::app()->name;
    
    $this->title = 'Настройки';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Параметры сайта</h5>
        
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
            echo '<p class="text-right">'.CHtml::link('+ Добавить параметр', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>


       