<?php
/* @var $this PrivateMessagesController */
/* @var $model PrivateMessages */

    $this->breadcrumbs=array(
        'Управление сообщениями'=>array('admin'),
        'Редактирование сообщения #'.$model->id,
    );

    $this->pageTitle = 'Редактирование сообщения #'.$model->id.' — '.Yii::app()->name;

    $this->title = 'Управление сообщениями';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование сообщения #<?php echo $model->id; ?> <small><?php echo CHtml::link('Посмотреть на сайте', array('view', 'id' => $model->id)); ?></small></h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>