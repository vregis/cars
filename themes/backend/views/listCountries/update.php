<?php
/* @var $this ListCountriesController */
/* @var $model ListCountries */

    $this->breadcrumbs=array(
        'Управление странами'=>array('admin'),
        'Редактирование страны «'.$model->name.'»',
    );

    $this->pageTitle = 'Редактирование страны «'.$model->name.'» — '.Yii::app()->name;

    $this->title = 'Управление странами';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование страны «<?php echo $model->name; ?>»</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>