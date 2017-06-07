<?php
/* @var $this CategoriesController */
/* @var $model Categories */

    $this->breadcrumbs=array(
        'Управление категориями'=>array('admin'),
        'Редактирование категории «'.$model->name.'»',
    );

    $this->pageTitle = 'Редактирование категории «'.$model->name.'» — '.Yii::app()->name;

    $this->title = 'Управление категориями';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование категории «<?php echo $model->name; ?>»</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>