<?php
/* @var $this WithdrawsController */
/* @var $model Withdraws */

    $this->breadcrumbs=array(
        'Управление заявками'=>array('admin'),
        'Добавление заявки',
    );

    $this->pageTitle = 'Добавление заявки — '.Yii::app()->name;

    $this->title = 'Заявки на вывод средств';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление заявки</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


