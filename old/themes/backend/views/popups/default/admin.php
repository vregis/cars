<?php
    /* @var $this PopupsController */
    /* @var $model Popups */

    $this->breadcrumbs=array(
        'Управление окнами',
    );

    $this->pageTitle = 'Управление окнами — '.Yii::app()->name;

    $this->title = 'Всплывающие окна';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление окнами</h5>
    </div>
    <div class="ibox-content">
        <?php
            echo '<p class="text-right">'.CHtml::link('+ Добавить окно', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>