<?php
/* @var $this OffersController */
/* @var $data Offers */
    if (!empty($data->primaryPhoto))
        $img_src = Yii::app()->request->hostInfo.'/resources/offers/400_'.$data->primaryPhoto->filename;
    else
        $img_src = Yii::app()->theme->baseUrl.'/img/blank_offer.png';
?>
                        
    <div class="row order-view">
        <div class="col-xs-12 col-sm-4 col-md-2">
            <?= CHtml::link(CHtml::image($img_src, $data->title, array('class' => 'img-responsive')), array('/offers/default/view', 'id' => $data->id)) ?>
            <ul class="order-view-tools">
                <li><?= CHtml::link('<i class="fa fa-pencil"></i>', array('/offers/default/edit', 'id' => $data->id), array('class' => 'text-default')) ?></li>
                <li><?= CHtml::link('<i class="fa fa-times"></i>', array('/offers/default/delete', 'id' => $data->id), array('class' => 'text-danger', 'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'submit' => array('delete', 'id' => $data->id), 'params' => array('id' => $data->id))) ?></li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-4 account-offer-description">
            <h4><?= CHtml::link($data->title, array('/offers/default/view', 'id' => $data->id)) ?> <?= CHtml::link(Yii::t('app', '[Edit]'), array('/offers/default/edit', 'id' => $data->id), array('class' => 'edit-link')) ?></h4>
            <?php $this->widget('application.components.widgets.feRatingStars', array(
                'rating'=>$data->rating,
                'htmlOptions'=>array('class' => 'star-rating-medium'),
            )); ?>
            <?php $fillInfo = $data->getInfoFillLevel(); ?>
            <h5 class="text-success"><?= Yii::t('app', 'Offer rating') ?>: <?= $fillInfo['percent'] ?>%</h5>
            <ul class="account-offer-points">
                <?php 
                if (!empty($fillInfo['skills']))
                    foreach ($fillInfo['skills'] as $skill) {
                        echo '<li><span>+'.$skill['value'].'%</span>: '.$skill['description'].'</li>';
                    }
                ?>
            </ul>
        </div>
        <div class="col-xs-12 col-md-3">
            <p class="text-center"><small><a href="#"><?= Yii::t('app', 'Comparing prices graph') ?></a></small></p>
        </div>
        <div class="col-xs-12 col-md-3">
            <p class="text-center"><small><a href="#"><?= Yii::t('app', 'Visitor for last 7 days graph') ?></a></small></p>
        </div>
    </div>