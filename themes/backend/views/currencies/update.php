<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */

    $this->breadcrumbs=array(
        'Управление валютами'=>array('admin'),
        'Редактирование валюты «'.$model->name.'»',
    );

    $this->pageTitle = 'Редактирование валюты «'.$model->name.'» — '.Yii::app()->name;

    $this->title = 'Управление валютами';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование валюты «<?php echo $model->name; ?>»</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>