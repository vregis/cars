<?php
/* @var $this ListProvincesController */
/* @var $model ListProvinces */

    $this->breadcrumbs=array(
        'Управление странами'=>array('/listCountries/admin'),
        'Редактирование страны «'.$model->country->name.'»'=>array('/listCountries/update', 'id' => $model->country_id),
        'Управление провинциями'=>array('admin', 'id' => $model->country_id),
        'Редактирование провинции «'.$model->name.'»',
    );

    $this->pageTitle = 'Редактирование провинции «'.$model->name.'» — '.Yii::app()->name;

    $this->title = 'Управление провинциями';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование провинциий «<?php echo $model->name; ?>»</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>