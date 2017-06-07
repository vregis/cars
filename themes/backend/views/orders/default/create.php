<?php
/* @var $this OrdersController */
/* @var $model Orders */

    $this->breadcrumbs=array(
        'Управление заказами'=>array('admin'),
        'Добавление заказа',
    );

    $this->pageTitle = 'Добавление заказа — '.Yii::app()->name;

    $this->title = 'Управление заказами';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление заказа</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


