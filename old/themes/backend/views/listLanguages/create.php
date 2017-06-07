<?php
/* @var $this ListCountriesController */
/* @var $model ListCountries */

    $this->breadcrumbs=array(
        'Управление языками'=>array('admin'),
        'Добавление языка',
    );

    $this->pageTitle = 'Добавление языка — '.Yii::app()->name;

    $this->title = 'Управление языками';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление языка</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


