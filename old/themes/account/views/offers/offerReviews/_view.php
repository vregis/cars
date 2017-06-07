<?php
/* @var $order Orders */
/* @var $review OfferReviews */
/* @var $offer Offers */
/* @var $client User */

$offer = $order->offer;
$review = $order->offerReviews[0];
$client = $order->client;
?>

    <div class="client-review">                        
        <div class="row">     
            <div class="col-xs-12 col-md-8">
                <div class="client-review-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8">
                            <div class="client-review-author">
                                <?= $client->profile->photoPreview ?>
                                <p>
                                    <?= CHtml::link($client->profile->name, $client->profileUrl) ?> 
                                    <?php if (!empty($client->profile->province)) echo CHtml::image(Yii::app()->theme->baseUrl.'/img/flags/'.mb_strtolower($client->profile->province->country->code, 'UTF-8').'.png'); ?><br />
                                    <?= Yii::app()->locale->dateFormatter->format(Yii::t('app', 'd MMM yyyy, HH:mm'), $review->date_created); ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 text-right">   
                            <?php $this->widget('application.components.widgets.feRatingStars', array(
                                'rating'=>$offer->rating,
                                'htmlOptions'=>array('class' => 'star-rating-small'),
                            )); ?>
                        </div>
                    </div>
                </div>

                <div class="client-review-content">
                    <?= $this->formatText($review->text) ?>
                </div> 
            </div>

            <div class="col-xs-12 col-md-4 review-photos">
                <?php if (!empty($review->photos)) { ?>
                <p class="text-muted"><?= Yii::t('app', 'Related photos') ?>:</p>
                <div class="row">
                    <?php
                    foreach ($review->photos as $photo) {
                        echo '<div class="col-xs-4 col-sm-3 col-md-4">';
                        echo CHtml::link(CHtml::image(Yii::app()->request->hostInfo.'/resources/offers/200_'.$photo->filename, '', array('class' => 'img-responsive')), Yii::app()->request->hostInfo.'/resources/offers/'.$photo->filename, array('class' => 'fancybox', 'title' => $client->profile->name, 'rel' => 'group_r'.$offer->id));
                        echo '</div>';
                    }
                    ?>
                </div>
                <?php } else { ?>
                <p class="text-muted"><?= Yii::t('app', 'No related photos.') ?></p>
                <?php } ?>
            </div>
        </div>
    </div>   