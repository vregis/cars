<?php
/* @var $this PlacesController */
/* @var $model Places */

    $this->breadcrumbs=array(
        'Управление POI'=>array('admin'),
        'Редактирование POI «'.$model->name.'»',
    );

    $this->pageTitle = 'Редактирование POI «'.$model->name.'» — '.Yii::app()->name;

    $this->title = 'Управление POI';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование name «<?php echo $model->name; ?>»</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>