<?php
    /* @var $this OfferReviewsController */
    /* @var $model OfferReviews */

    $this->breadcrumbs=array(
        'Управление предложениями'=>array('/offers/default/admin'),
        $model->offer->title=>array('/offers/default/update', 'id'=>$model->offer_id),
        'Управление отзывами',
    );

    $this->pageTitle = 'Управление отзывами — '.Yii::app()->name;

    $this->title = 'Предложения';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/default/_tabs', array('model'=>$model->offer)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Управление отзывами</h3>
                <br />
                <?php
                    $this->renderPartial('admingrid', array('model'=>$model));
                ?>
            </div>
        </div>
    </div>
</div>