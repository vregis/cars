<?php
/* @var $this ArticlesController */
/* @var $model Articles */

    $this->breadcrumbs=array(
            'Управление статьями'=>array('admin'),
            'Редактирование статьи #'.$model->id,
    );

    $this->pageTitle = 'Редактирование статьи #'.$model->id.' — '.Yii::app()->name;

    $this->title = 'Статьи';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование статьи #<?php echo $model->id; ?> <small><?php echo CHtml::link('Посмотреть на сайте', array('/articles/default/view', 'url_name'=>$model->url_name)); ?></small></h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>