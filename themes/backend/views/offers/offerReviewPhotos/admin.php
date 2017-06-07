<?php
    /* @var $this OfferReviewPhotosController */
    /* @var $model OfferReviewPhotos */

    $this->breadcrumbs=array(
        'Управление предложениями'=>array('/offers/default/admin'),
        $model->review->offer->title=>array('/offers/default/update', 'id'=>$model->review->offer_id),
        'Управление отзывами'=>array('/offers/offerReviews/admin', 'id'=>$model->review_id),
        'Отзыв по заказу #'.$model->review->order_id=>array('/offers/offerReviews/update', 'id'=>$model->review_id),
        'Фотографии к отзыву',
    );

    $this->pageTitle = 'Фотографии к отзыву — '.Yii::app()->name;

    $this->title = 'Предложения';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/default/_tabs', array('model'=>$model->review->offer)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Фотографии к отзыву</h3>
                <br />
                <?php echo $this->renderPartial('_form', array('model'=>$form_model)); ?>
            </div>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$model->search(),
        'template'=>'{items}',
        'itemView'=>'_view',
        'itemsCssClass'=>'row sortable-view',
        'emptyText'=>'<p class="text-center">Нет загруженных фотографий.</p>',
        'htmlOptions'=>array('data-model' => 'offerReviewPhotos'),
    ));
    ?>
    <div id="serialize_output"></div>
</div>