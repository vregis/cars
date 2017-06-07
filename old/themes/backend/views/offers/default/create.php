<?php
/* @var $this OffersController */
/* @var $model Offers */

    $this->breadcrumbs=array(
        'Управление предложениями'=>array('admin'),
        'Добавление предложения',
    );

    $this->pageTitle = 'Добавление предложения — '.Yii::app()->name;

    $this->title = 'Предложения';
?>


<div class="tabs-container">    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>