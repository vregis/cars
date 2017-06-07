<?php
/* @var $this OfferFaqController */
/* @var $model OfferFaq */

    $this->breadcrumbs=array(
        'Управление предложениями'=>array('/offers/default/admin'),
        $model->offer->title=>array('/offers/default/update', 'id'=>$model->offer_id),
        'Управление вопросами'=>array('admin', 'id'=>$model->offer_id),
        'Редактирование ответа #'.$model->id,
    );

    $this->pageTitle = 'Редактирование ответа #'.$model->id.' — '.Yii::app()->name;

    $this->title = 'Предложения';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/default/_tabs', array('model'=>$model->offer)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Редактирование ответа #<?php echo $model->id; ?></h3>
                <br />
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>