<?php
/* @var $this ProfileController */
/* @var $model User */
/* @var $profile Profile */
    $this->pageTitle = $profile->name.' | '.Yii::app()->name;
    
    $this->breadcrumbs = array(
        $profile->name
    );
?>

        <!-- Main content -->
        <div class="container top-block">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <div class="affixed-block">
                                <div class="client-info">
                                    <h5><?= Yii::t('app', 'About') ?> <?= $profile->firstname; ?></h5>
                                    <?= (($profile->is_company)?('<p><strong>'.Yii::t('app', 'Company account').'</strong></p>'):('')) ?>
                                    <p><?= Yii::t('app', 'Club member since') ?> <?= Yii::app()->locale->dateFormatter->format('yyyy', $model->createtime); ?></p>
                                    <p><?= Yii::t('app', 'From') ?> <strong><?= $profile->fullCity ?></strong></p>
                                    <p><?= Yii::t('app', 'Total offered') ?>: <?= CHtml::link($this->plural(count($model->activeOffers), Yii::t('app', 'item1'), Yii::t('app', 'items2'), Yii::t('app', 'items5')), $model->profileUrl) ?></p>
                                    <?php 
                                    if ($model->isApprovedClient() || $model->id == Yii::app()->user->id) {
                                        echo '<br /> <h5>'.Yii::t('app', 'Phone(s):').'</h5>';                                        
                                        echo '<p>p.: '.$profile->public_phone.'<br />';
                                        echo 'p.: '.$profile->alter_phone.'<br />';
                                        echo '</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>  
                        <div class="col-xs-12 col-md-8 client-photo">
                            <?= CHtml::link(CHtml::image($profile->rawPhoto, $profile->name, array('class' => 'img-responsive')), Yii::app()->request->hostInfo.'/resources/users/'.$profile->photo, array('class' => 'fancybox', 'rel'=>'group1')); ?>
                                                        
                            <div class="row" style="margin-top: 30px;">
                                <div class="col-xs-6">
                                    <?php if (!empty($profile->photo2)) echo CHtml::link(CHtml::image($profile->getSquarePhoto('photo2'), $profile->name, array('class' => 'img-responsive')), Yii::app()->request->hostInfo.'/resources/users/'.$profile->photo2, array('class' => 'fancybox', 'rel'=>'group1')); ?>
                                </div>
                                <div class="col-xs-6">
                                    <?php if (!empty($profile->photo3)) echo CHtml::link(CHtml::image($profile->getSquarePhoto('photo3'), $profile->name, array('class' => 'img-responsive')), Yii::app()->request->hostInfo.'/resources/users/'.$profile->photo3, array('class' => 'fancybox', 'rel'=>'group1')); ?>
                                </div>
                            </div>  
                            
                            <h2><span class="text-default"><?= Yii::t('app', '{user}’s Offers', array('{user}' => $profile->firstname)); ?></span>  /  <?= CHtml::link(Yii::t('app', 'Archived offers'), array('#')); ?></h2>
                            <?php 
                            if (!empty($model->activeOffers)) {
                                foreach ($model->activeOffers as $key => $offer) {
                                    if ($key % 2 == 0) echo '<div class="row">';
                                    echo '<div class="col-xs-12 col-sm-6">';
                                    $this->renderPartial('//offers/default/_view', array('data' => $offer));
                                    echo '</div>';
                                    if ($key % 2 == 1) echo '</div>';
                                }
                                if (count($model->activeOffers) % 2 == 1) echo '</div>';
                            }
                            ?>
                        </div> 
                    </div>
                </div>  
                <div class="col-xs-12 col-sm-6 client-profile">
                    <div class="client-rating">
                        <?php $this->widget('application.components.widgets.feRatingStars', array(
                            'rating'=>$model->rating,
                            'htmlOptions'=>array('class' => 'star-rating-small'),
                        )); ?>
                        <?= Yii::t('app', 'by') ?> <?= $this->plural(count($model->reviews), 'client', 'clients', 'clients'); ?>
                    </div>
                    <h1><?= $profile->name; ?> <?php if ($model->is_approved) echo '<span class="client-verification"><i class="fa fa-check-circle-o"></i> '.Yii::t('app', 'approved').'</span>'; ?></h1>
                    <p><small><span class="text-muted"><?= Yii::t('app', 'Last visited') ?>:</span> <strong><?= Yii::app()->locale->dateFormatter->format(Yii::t('app', 'd MMMM yyyy, H:mm'), $model->lastvisit); ?></strong></small></p>
                    
                    <div class="row client-about">
                        <div class="col-xs-12 col-md-8">
                            <p><?= $profile->notes; ?></p>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <?= CHtml::link(Yii::t('app', 'Contact Me'), array('/user/privateMessages/dialog', 'id' => $model->id), array('class' => 'btn btn-block btn-primary')) ?>
                        </div>
                    </div>
                    
                    <div class="client-addresses">
                        <?php 
                        $pins = array();
                        if (!empty($model->addresses)) {
                            foreach ($model->addresses as $address) {
                                $pins[] = array('coords' => array($address->lat, $address->lng), 'label' => '');
                            }

                            $this->widget('application.components.widgets.feMap', array(
                                'pins'=>$pins,
                                'height' => '250'
                            ));
                        }
                        ?>
                        <p>
                            <?php 
                            if (!empty($model->addresses)) {
                                $addresses = array();
                                foreach ($model->addresses as $address) {
                                    $addresses[] = $address->getFullAddress(true);
                                }
                                echo implode('<br />', $addresses);
                            }
                            ?>                                        
                        </p>
                    </div>
                    
                    <p class="reviews-filter"><a href="#" data-type="negative"><?= Yii::t('app', 'Only negative') ?></a> / <a href="#" data-type="all"><?= Yii::t('app', 'All') ?></a></p>
                    <h3><?= Yii::t('app', 'Clients\' Reviews') ?></h3>
                    
                    <div class="client-stats">
                        <div class="row client-stats-parameter">
                            <div class="col-xs-4 parameter-name">
                                <?= Yii::t('app', 'Communications') ?>
                            </div>
                            <?php $this->widget('application.components.widgets.feLineRating', array('rating'=>$model->parameter_1)); ?>
                        </div>
                        <div class="row client-stats-parameter">
                            <div class="col-xs-4 parameter-name">
                                <?= Yii::t('app', 'Punctuality') ?>
                            </div>
                            <?php $this->widget('application.components.widgets.feLineRating', array('rating'=>$model->parameter_2)); ?>
                        </div>
                        <div class="row client-stats-parameter">
                            <div class="col-xs-4 parameter-name">
                                <?= Yii::t('app', 'Accuracy') ?>
                            </div>
                            <?php $this->widget('application.components.widgets.feLineRating', array('rating'=>$model->parameter_3)); ?>
                        </div>
                    </div>
                    
                    <?php
                    if (!empty($model->reviews)) 
                        foreach ($model->reviews as $review) {
                            $this->renderPartial('/userReviews/_view', array('data' => $review));
                        }
                    ?>
                    
                </div>  
            </div>  
        </div>  