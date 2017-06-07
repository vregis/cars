<?php
/* @var $this SiteVarsController */
/* @var $model SiteVars */

    $this->breadcrumbs=array(
        'Параметры сайта'=>array('admin'),
        'Редактирование параметра «'.$model->name.'»'
    );

    $this->pageTitle = 'Редактирование параметра «'.$model->name.'» — '.Yii::app()->name;
    
    $this->title = 'Настройки';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование параметра «<?php echo $model->name; ?>»</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>