<?php
/* @var $this ListProvincesController */
/* @var $model ListProvinces */

    $this->breadcrumbs=array(
        'Управление странами'=>array('/listCountries/admin'),
        'Редактирование страны «'.$model->country->name.'»'=>array('/listCountries/update', 'id' => $model->country_id),
        'Управление провинциями'=>array('admin', 'id' => $model->country_id),
        'Добавление провинции',
    );

    $this->pageTitle = 'Добавление провинции — '.Yii::app()->name;

    $this->title = 'Управление провинциями';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление провинции</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


