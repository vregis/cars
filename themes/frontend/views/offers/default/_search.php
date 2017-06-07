<?php
/* @var $this OffersController */
/* @var $data Offers */
    if (!empty($data->primaryPhoto))
        $img_src = Yii::app()->request->hostInfo.'/resources/offers/400_'.$data->primaryPhoto->filename;
    else
        $img_src = Yii::app()->theme->baseUrl.'/img/blank_offer.png';

    //Check if is favourite
    $is_favourite = false;
    if (!empty($this->userModel->favourites))
        foreach ($this->userModel->favourites as $fav) {
            if ($fav->offer_id == $data->id)
                $is_favourite = true;
        }
     
    //Addresses IDs
    $addresses_ids = '';
    if (!empty($data->addresses)) {
        $addresses_list = array();
        foreach ($data->addresses as $address) {
            $addresses_list[] = $address->id;
        }
        $addresses_ids = implode(',', $addresses_list);
    }
?>

    <div class="row offer-short-info" data-address-id="<?= $addresses_ids ?>">
        <div class="col-xs-12 col-md-4 col-lg-3 offer-preview">
            <?= CHtml::link(CHtml::image($img_src, $data->title, array('class' => 'img-responsive')), array('/offers/default/view', 'id' => $data->id), array('class' => 'offer-image')) ?>
            <a href="#" class="offer-fav <?php if ($is_favourite) echo 'fav-set'; ?>" data-id="<?= $data->id ?>" data-url="<?= Yii::app()->createAbsoluteUrl('/offers/default/addToFavourites'); ?>">
                <i class="fa fa-heart-o"></i>
                <i class="fa fa-heart"></i>
            </a>
            <div class="owner-info">
                <?= $data->owner->profile->photoPreview ?>
                <?= CHtml::link($data->owner->profile->firstname, $data->owner->profileUrl) ?> 
                <?php $this->widget('application.components.widgets.feRatingStars', array(
                    'rating'=>$data->owner->rating,
                    'htmlOptions'=>array('class' => 'star-rating-small'),
                )); ?>
            </div>
        </div>
        <div class="col-xs-12 col-md-8 col-lg-9 offer-description">
            <h2><?= CHtml::link($data->title.' <span>'.$data->year.'</span>', array('/offers/default/view', 'id' => $data->id)) ?></h2>
            <div class="offer-stats">
                <?php $this->widget('application.components.widgets.feRatingStars', array(
                    'rating'=>$data->rating,
                    'htmlOptions'=>array('class' => 'star-rating-medium'),
                )); ?>
                <p><?= CHtml::link($this->plural(count($data->reviews), Yii::t('app', 'review1'), Yii::t('app', 'reviews2'), Yii::t('app', 'reviews5')), array('/offers/default/view', 'id' => $data->id), array('class' => 'text-primary')) ?>&nbsp;&nbsp;-&nbsp;&nbsp;<span class="text-warning"><?= $this->plural(count($data->favourites), Yii::t('app', 'save1'), Yii::t('app', 'saves2'), Yii::t('app', 'saves5')) ?></span>&nbsp;&nbsp;-&nbsp;&nbsp;<span class="text-muted"><?= $this->plural($data->views, Yii::t('app', 'view1'), Yii::t('app', 'views2'), Yii::t('app', 'views5')) ?></span></p>
            </div>
            <!--<p class="offer-price"><?= $this->formatPrice($data->price_hourly); ?> <small class="text-muted thin">/ <?= Yii::t('app', 'hour') ?></small></p>-->
            <p class="offer-price"><small class="text-muted thin"><?= Yii::t('app', 'From') ?></small> <?= $this->formatPrice($data->lp); ?> <small class="text-muted thin"><?= Yii::t('app', 'to') ?> </small><?= $this->formatPrice($data->hp); ?></p>
            <p class="offer-more"><?= CHtml::link(Yii::t('app', 'Read more...'), array('/offers/default/view', 'id' => $data->id)) ?></p>
            <p class="offer-details">
                <span class="pull-right"><?= Yii::t('app', 'since') ?> <?= Yii::app()->locale->dateFormatter->format(Yii::t('app', 'd.MM.yyyy'), $data->date_created); ?></span>
                <?php 
                if (!empty($data->addresses)) {
                    $address = $data->addresses[0];
                    echo $address->getFullAddress(true);
                    
                    if (count($data->addresses) > 1)
                        echo '<br />+ '.(count($data->addresses) - 1).' '.Yii::t('app', 'more');
                }
                
                if (isset($_GET['dd'])) {
                    $dates = explode(' ~ ', $_GET['dd']);
                    if (!empty($dates[0]) && !empty($dates[1])) {
                        $blocks = $data->getBlocksArray($dates[0], $dates[1]);
                        if (!empty($blocks)) {
                            echo '<br /><br /><a href="#blocked'.$data->id.'" data-toggle="collapse" class="dashed"><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;'.Yii::t('app', 'Unavailable dates').'</a><br /><span id="blocked'.$data->id.'" class="collapse">';
                            $blocked_arr = OfferBlocks::formatForList($blocks);
                            echo implode('<br/>', $blocked_arr);
                            echo '</span>';
                        }
                    }
                }
                ?>  
            </p>
        </div>
    </div>