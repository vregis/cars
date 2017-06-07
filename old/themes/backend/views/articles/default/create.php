<?php
/* @var $this ArticlesController */
/* @var $model Articles */

    $this->breadcrumbs=array(
        'Управление статьями'=>array('admin'),
        'Добавление статьи',
    );

    $this->pageTitle = 'Добавление статьи — '.Yii::app()->name;

    $this->title = 'Статьи';

?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление статьи</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


