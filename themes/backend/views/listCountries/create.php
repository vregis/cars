<?php
/* @var $this ListCountriesController */
/* @var $model ListCountries */

    $this->breadcrumbs=array(
        'Управление странами'=>array('admin'),
        'Добавление страны',
    );

    $this->pageTitle = 'Добавление страны — '.Yii::app()->name;

    $this->title = 'Управление странами';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление страны</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


