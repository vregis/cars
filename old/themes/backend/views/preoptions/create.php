<?php
/* @var $this CategoriesController */
/* @var $model Categories */

    $this->breadcrumbs=array(
        'Управление категориями'=>array('/categories/admin'),
        'Редактирование категории «'.$model->category->name.'»'=>array('/categories/update', 'id' => $model->category_id),
        'Управление опциями'=>array('admin', 'id' => $model->category_id),
        'Добавление опции',
    );

    $this->pageTitle = 'Добавление опции — '.Yii::app()->name;

    $this->title = 'Категории';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление опции</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


