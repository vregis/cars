<?php
/* @var $this MetaTagsController */
/* @var $model MetaTags */

    $this->breadcrumbs=array(
        'Управление мета тегами'=>array('admin'),
        'Добавление мета тега',
    );

    $this->pageTitle = 'Добавление мета тега — '.Yii::app()->name;

    $this->title = 'МЕТА теги';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление мета тега</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


