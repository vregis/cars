<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */

    $this->breadcrumbs=array(
        'Управление валютами'=>array('admin'),
        'Добавление валюты',
    );

    $this->pageTitle = 'Добавление валюты — '.Yii::app()->name;

    $this->title = 'Управление валютами';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление валюты</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


