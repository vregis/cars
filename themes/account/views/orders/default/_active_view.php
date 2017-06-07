<?php
/* @var $this OrdersController */
/* @var $data Orders */
/* @var $offer Offers */
/* @var $owner Profiles */

    $offer = $data->offer;
    $owner = $data->offer->owner->profile;
    
    if (!empty($offer->primaryPhoto))
        $img_src = Yii::app()->request->hostInfo.'/resources/offers/400_'.$offer->primaryPhoto->filename;
    else
        $img_src = Yii::app()->theme->baseUrl.'/img/blank_offer.png';
?>
                        
    <div class="row order-view">
        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-3">
            <?= CHtml::link(CHtml::image($img_src, $offer->title, array('class' => 'img-responsive')), array('/orders/default/view', 'id' => $data->id)) ?>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-5">
            <h4><?= CHtml::link($offer->title, array('/orders/default/view', 'id' => $data->id)) ?></h4>
            <p class="offer-view-client"><?= Yii::t('app', 'offered by') ?> <?= CHtml::link($owner->name, array('/user/profile/view', 'id' => $owner->user_id)) ?></p>
            <p class="price-block"><?= Yii::t('app', 'Total') ?>: <?= $this->formatPrice($data->total_cost) ?></p>
            <p>
                <span class="text-muted"><?= Yii::t('app', 'From') ?>:</span> <?= $data->addressFrom->address->getFullAddress(true) ?> <i class="fa fa-map-marker"></i><br />
                <span class="text-muted"><?= Yii::t('app', 'To') ?>:</span> <?= $data->addressTo->address->getFullAddress(true) ?> <i class="fa fa-map-marker"></i>
            </p>            
            <?php
            if (!empty($data->options)) {
                echo '<br /><p class="text-serif text-thick"><big>'.Yii::t('app', 'Additional Options').'</big></p>';
                echo '<ul>';
                foreach ($data->options as $option) {
                    echo '<li>'.$option->title.'</li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-4">
            <div class="order-details">
                <div class="row">
                    <div class="col-xs-12 col-sm-5">
                        <h5><?= Yii::t('app', 'Reception') ?></h5>
                        <big><?= Yii::app()->locale->dateFormatter->format("d", $data->date_since) ?></big>
                        <p><?= Yii::app()->locale->dateFormatter->format("MMM, yyyy", $data->date_since) ?></p>
                        <p><small><?= Yii::app()->locale->dateFormatter->format("H:mm", $data->date_since) ?></small></p>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <span class="date-between">~</span>
                    </div>
                    <div class="col-xs-12 col-sm-5">
                        <h5><?= Yii::t('app', 'Return') ?></h5>
                        <big><?= Yii::app()->locale->dateFormatter->format("d", $data->date_for) ?></big>
                        <p><?= Yii::app()->locale->dateFormatter->format("MMM, yyyy", $data->date_for) ?></p>
                        <p><small><?= Yii::app()->locale->dateFormatter->format("H:mm", $data->date_for) ?></small></p>
                    </div>
                </div>
                <p class="text-center total-days"><?= Yii::t('app', 'total') ?> <?= $this->plural($data->daysDifference, Yii::t('app', 'day'), Yii::t('app', 'days2'), Yii::t('app', 'days5')) ?></p>
            </div>
        </div>
        
        <hr />
    </div>

