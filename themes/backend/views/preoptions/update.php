<?php
/* @var $this CategoriesController */
/* @var $model Categories */

    $this->breadcrumbs=array(
        'Управление категориями'=>array('/categories/admin'),
        'Редактирование категории «'.$model->category->name.'»'=>array('/categories/update', 'id' => $model->category_id),
        'Управление опциями'=>array('admin', 'id' => $model->category_id),
        'Редактирование опции «'.$model->title.'»',
    );

    $this->pageTitle = 'Редактирование опции «'.$model->title.'» — '.Yii::app()->name;

    $this->title = 'Категории';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование опции «<?php echo $model->title; ?>»</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>