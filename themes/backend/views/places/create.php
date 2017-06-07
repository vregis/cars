<?php
/* @var $this PlacesController */
/* @var $model Places */

    $this->breadcrumbs=array(
        'Управление POI'=>array('admin'),
        'Добавление POI',
    );

    $this->pageTitle = 'Добавление POI — '.Yii::app()->name;

    $this->title = 'Управление POI';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление POI</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


