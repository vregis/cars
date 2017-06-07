<?php
/* @var $this NewsController */
/* @var $model News */

    $this->breadcrumbs=array(
        'Пользователи'=>array('admin'),
        $model->profile->name
    );

    $this->pageTitle = $model->profile->name.' — '.Yii::app()->name;

    $this->title = 'Пользователи';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('_tabs', array('model'=>$model)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <?php echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile)); ?>
            </div>
        </div>
    </div>
</div>