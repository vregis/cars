<?php
/* @var $this UserFavouritesController */
/* @var $data UserFavourites */
    $offer = $data->offer;

    if (!empty($data->offer->primaryPhoto))
        $img_src = Yii::app()->request->hostInfo.'/resources/offers/200_'.$offer->primaryPhoto->filename;
    else
        $img_src = Yii::app()->theme->baseUrl.'/img/blank_offer.png';
?>

<div class="col-xs-12 col-md-6">
    <div class="row order-view">
        <div class="col-xs-12 col-sm-4">
            <?= CHtml::link(CHtml::image($img_src, $offer->title, array('class' => 'img-responsive')), array('/offers/default/view', 'id' => $offer->id)) ?>
            <ul class="order-view-tools">
                <li>
                    <?= CHtml::link('<i class="fa fa-times"></i>', array('delete', 'id' => $data->id), array('class' => 'text-danger', 'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'submit' => array('delete', 'id' => $data->id), 'params' => array('id' => $data->id))); ?>
                </li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-8">
            <h4><?= CHtml::link($offer->title, array('/offers/default/view', 'id' => $offer->id)) ?></h4>
            <p class="offer-view-client"><?= Yii::t('app', 'by') ?> <?= CHtml::link($offer->owner->profile->name, array('/user/profile/view', 'id' => $offer->owner_id)) ?></p>

            <p class="price-block">
                <?= $this->formatPrice($offer->price_hourly); ?> <small class="text-muted thin">/ <?= Yii::t('app', 'hour') ?></small><br />
                <?= $this->formatPrice($offer->price_daily); ?> <small class="text-muted thin">/ <?= Yii::t('app', 'day') ?></small>
            </p>
        </div>
    </div>
</div>

<?php
if ($index % 2 == 1)
    echo '<div class="visible-md visible-lg clearfix"></div>';
?>