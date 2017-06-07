<?php
/* @var $this ParametersController */
/* @var $model Parameters */

    $this->breadcrumbs=array(
        'Управление группами параметров'=>array('admin'),
        'Добавление группы',
    );

    $this->pageTitle = 'Добавление группы — '.Yii::app()->name;

    $this->title = 'Параметры';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление группы</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


