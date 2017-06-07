<?php
/* @var $this OfferReviewsController */
/* @var $data OfferReviews */
?>

    <div class="client-review">                        
        <div class="row">     
            <div class="col-xs-12 col-md-8">
                <div class="client-review-header">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <div class="client-review-author">
                                <?= $data->order->client->profile->photoPreview ?>
                                <p>
                                    <?= CHtml::link($data->order->client->profile->name, $data->order->client->profileUrl) ?> 
                                    <?php if (!empty($data->order->client->profile->province)) echo CHtml::image(Yii::app()->theme->baseUrl.'/img/flags/'.mb_strtolower($data->order->client->profile->province->country->code, 'UTF-8').'.png'); ?><br />
                                    <?= Yii::app()->locale->dateFormatter->format(Yii::t('app', 'd MMM yyyy, HH:mm'), $data->date_created); ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-6">   
                            <?php $this->widget('application.components.widgets.feRatingStars', array(
                                'rating'=>$data->rating,
                                'htmlOptions'=>array('class' => 'star-rating-small'),
                            )); ?>
                        </div>
                    </div>
                </div>

                <div class="client-review-content">
                    <?= $this->formatText($data->text) ?>
                </div> 
            </div>

            <div class="col-xs-12 col-md-4 review-photos">
                <?php if (!empty($data->photos)) { ?>
                <p class="text-muted"><?= Yii::t('app', 'Related photos') ?>:</p>
                <div class="row">
                    <?php
                    foreach ($data->photos as $photo) {
                        echo '<div class="col-xs-4 col-sm-3 col-md-4">';
                        echo CHtml::link(CHtml::image(Yii::app()->request->hostInfo.'/resources/offers/200_'.$photo->filename, '', array('class' => 'img-responsive')), Yii::app()->request->hostInfo.'/resources/offers/'.$photo->filename, array('class' => 'fancybox', 'title' => $data->order->client->profile->name, 'rel' => 'group_r'.$data->id));
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