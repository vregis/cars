<?php
/* @var $this OffersController */
/* @var $data Offers */
    if (!empty($data->primaryPhoto))
        $img_src = Yii::app()->request->hostInfo.'/resources/offers/200_'.$data->primaryPhoto->filename;
    else
        $img_src = Yii::app()->theme->baseUrl.'/img/blank_offer.png';
?>

    <div class="offer-map-view">
        <?= CHtml::link(
            CHtml::image($img_src, $data->title, array('class' => 'img-responsive')), 
            Yii::app()->createAbsoluteUrl('/offers/default/view', array('id' => $data->id))
        ) ?>
        <h4><?= CHtml::link($data->title, array('/offers/default/view', 'id' => $data->id)) ?></h4>
        <?php $this->widget('application.components.widgets.feRatingStars', array(
            'rating'=>$data->rating,
            'htmlOptions'=>array('class' => 'star-rating-small'),
        )); ?>
        <p class="offer-price"><?= $this->formatPrice($data->price_daily); ?> <small class="text-muted thin"></small></p>
    </div>