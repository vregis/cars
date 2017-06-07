<?php
/* @var $this PopupsController */
/* @var $model Popups */

    $this->breadcrumbs=array(
        'Управление окнами'=>array('admin'),
        'Редактирование окна #'.$model->id,
    );

    $this->pageTitle = 'Редактирование окна #'.$model->id.' — '.Yii::app()->name;

    $this->title = 'Всплывающие окна';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование окна #<?php echo $model->id; ?></h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>