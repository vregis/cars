<?php
/* @var $this OffersController */
/* @var $model Offers */

    $this->breadcrumbs=array(
        'Управление предложениями'=>array('admin'),
        $model->title,
    );

    $this->pageTitle = '"'.$model->title.'" — '.Yii::app()->name;

    $this->title = 'Предложения';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('_tabs', array('model'=>$model)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <?php echo $this->renderPartial('_form', array('model'=>$model, 'a_addresses'=>$a_addresses)); ?>
            </div>
        </div>
    </div>
</div>