<?php
/* @var $this ListCountriesController */
/* @var $model ListCountries */

    $this->breadcrumbs=array(
        'Управление языками'=>array('admin'),
        'Редактирование языка «'.$model->name.'»',
    );

    $this->pageTitle = 'Редактирование языка «'.$model->name.'» — '.Yii::app()->name;

    $this->title = 'Управление языками';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование языка «<?php echo $model->name; ?>»</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>