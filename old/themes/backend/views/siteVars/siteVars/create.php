<?php
/* @var $this SiteVarsController */
/* @var $model SiteVars */

    $this->breadcrumbs=array(
        'Параметры сайта'=>array('admin'),
        'Добавление нового параметра'
    );

    $this->pageTitle = 'Добавление нового параметра — '.Yii::app()->name;
    
    $this->title = 'Настройки';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление нового параметра</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>