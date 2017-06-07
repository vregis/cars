<?php
/* @var $this ParametersController */
/* @var $model Parameters */

    $this->breadcrumbs=array(
            'Управление параметрами'=>array('admin'),
            'Редактирование параметра «'.$model->name.'»',
    );

    $this->pageTitle = 'Редактирование параметра «'.$model->name.'» — '.Yii::app()->name;

    $this->title = 'Параметры';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование параметра «<?php echo $model->name; ?>»</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>