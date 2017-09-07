<?php
/* @var $this OffersController */
/* @var $data Offers */
    if (!empty($data->primaryPhoto))
        $img_src = Yii::app()->request->hostInfo.'/resources/offers/200_'.$data->primaryPhoto->filename;
    else
        $img_src = Yii::app()->theme->baseUrl.'/img/blank_offer.png';
?>

    <div class="offer-view-lite">
        <?= CHtml::link(CHtml::image($img_src, $data->title, array('class' => 'img-responsive')), array('/offers/default/view', 'id' => $data->id)) ?>
        <h4><?= CHtml::link($data->title, array('/offers/default/view', 'id' => $data->id)) ?></h4>
        <?php $this->widget('application.components.widgets.feRatingStars', array(
            'rating'=>$data->rating,
            'htmlOptions'=>array('class' => 'star-rating-small'),
        )); ?>
        <p class="offer-price"><?= $this->formatPrice((new Offers())->getPriceDaily($data->id)); ?></p>
    </div>