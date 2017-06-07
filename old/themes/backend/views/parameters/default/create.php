<?php
/* @var $this ParametersController */
/* @var $model Parameters */

    $this->breadcrumbs=array(
        'Управление параметрами'=>array('admin'),
        'Добавление параметра',
    );

    $this->pageTitle = 'Добавление параметра — '.Yii::app()->name;

    $this->title = 'Параметры';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление параметра</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


