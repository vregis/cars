<?php
/* @var $this CategoriesController */
/* @var $model Categories */

    $this->breadcrumbs=array(
        'Управление категориями'=>array('admin'),
        'Добавление категории',
    );

    $this->pageTitle = 'Добавление категории — '.Yii::app()->name;

    $this->title = 'Управление категориями';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление категории</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


