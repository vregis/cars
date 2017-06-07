<?php
/* @var $this PopupsController */
/* @var $model Popups */

    $this->breadcrumbs=array(
        'Управление окнами'=>array('admin'),
        'Добавление окна',
    );

    $this->pageTitle = 'Добавление окна — '.Yii::app()->name;

    $this->title = 'Всплывающие окна';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление окна</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


