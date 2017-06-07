<?php
/* @var $this OfferOptionsController */
/* @var $model OfferOptions */

    $this->breadcrumbs=array(
        'Управление предложениями'=>array('/offers/default/admin'),
        $model->offer->title=>array('/offers/default/update', 'id'=>$model->offer_id),
        'Управление опциями'=>array('admin', 'id'=>$model->offer_id),
        'Опция «'.$model->title.'»',
    );

    $this->pageTitle = 'Опция «'.$model->title.'» — '.Yii::app()->name;

    $this->title = 'Предложения';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/default/_tabs', array('model'=>$model->offer)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Опция «<?php echo $model->title; ?>»</h3>
                <br />
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>