<?php
/* @var $this OfferReviewsController */
/* @var $model OfferReviews */

    $this->breadcrumbs=array(
        'Управление предложениями'=>array('/offers/default/admin'),
        $model->offer->title=>array('/offers/default/update', 'id'=>$model->offer_id),
        'Управление отзывами'=>array('admin', 'id'=>$model->offer_id),
        'Отзыв по заказу #'.$model->order_id
    );

    $this->pageTitle = 'Отзыв по заказу #'.$model->order_id.' — '.Yii::app()->name;

    $this->title = 'Предложения';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/default/_tabs', array('model'=>$model->offer)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Отзыв по заказу #<?php echo $model->order_id; ?></h3>
                <br />
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>