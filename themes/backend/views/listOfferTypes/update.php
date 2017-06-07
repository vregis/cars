<?php
/* @var $this ListOfferTypesController */
/* @var $model ListOfferTypes */

    $this->breadcrumbs=array(
        'Управление типами предложений'=>array('admin'),
        'Редактирование типа #'.$model->id,
    );

    $this->pageTitle = 'Редактирование типа #'.$model->id.' — '.Yii::app()->name;

    $this->title = 'Управление типами предложений';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование типа #<?php echo $model->id; ?> <small><?php echo CHtml::link('Посмотреть на сайте', array('view', 'id' => $model->id)); ?></small></h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>