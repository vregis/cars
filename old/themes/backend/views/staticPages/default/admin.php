<?php
/* @var $this StaticPagesController */
/* @var $model StaticPages */

    $this->breadcrumbs=array(
        'Управление инфо-страницами',
    );

    $this->pageTitle = 'Управление инфо-страницами — '.Yii::app()->name;

    $this->title = 'Инфо-страницы';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление инфо-страницами</h5>
        
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
            echo '<p class="text-right">'.CHtml::link('+ Добавить страницу', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>