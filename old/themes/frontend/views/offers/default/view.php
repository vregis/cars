<?php
    
$this->breadcrumbs = array(
    Yii::t('app', 'Search') => array('/site/search'),
    $model->title
);

$this->pageTitle = $model->title;

Yii::app()->clientScript->registerMetaTag($model->description, 'description');

if (!empty($model->primaryPhoto)) {
    Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.'/resources/offers/'.$model->primaryPhoto->filename, NULL, NULL, array('property'=>'og:image'));            
}

//Check if is favourite
$is_favourite = false;
if (!empty($this->userModel->favourites))
    foreach ($this->userModel->favourites as $fav) {
        if ($fav->offer_id == $model->id)
            $is_favourite = true;
    }
    
    
$pins = array();
if (!empty($model->addresses))
    foreach ($model->addresses as $address) {
        $pins[] = array('coords' => array($address->lat, $address->lng), 'label' => $address->fullAddress);
    }

?>

        <!-- Main content -->
        <div class="container top-block">
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-lg-2">
                    <div class="affixed-block">
                        <div class="offer-price-large">
                            <p class="price-type"><?= Yii::t('app', 'Price per Hour') ?></p>
                            <p class="price-value"><?= $this->formatPrice($model->price_hourly); ?></p>
                            <p class="price-type"><?= Yii::t('app', 'Price per Day') ?></p>
                            <p class="price-value"><?= $this->formatPrice($model->price_daily); ?></p>
                            <a href="#" class="btn btn-success btn-solid btn-block btn-submit" data-target="additional-options-form"><?= Yii::t('app', 'Order now') ?> <i class="fa fa-angle-right"></i></a><br />
                            <!--<p class="text-center text-danger"><small><?= Yii::t('app', 'Extra charges may apply') ?>&nbsp;&nbsp;</small><i class="fa fa-question-circle"></i></p>-->
                        </div>
                        <div class="client-info">
                            <div class="owner-preview">
                                <?= $model->owner->profile->photoPreview ?>
                                <?= CHtml::link($model->owner->profile->shortName, $model->owner->profileUrl, array('class' => 'owner-name')) ?> 
                                <?php $this->widget('application.components.widgets.feRatingStars', array(
                                    'rating'=>$model->owner->rating,
                                    'htmlOptions'=>array('class' => 'star-rating-small'),
                                )); ?>
                            </div>
                            <?= (($model->owner->profile->is_company)?('<p><strong>'.Yii::t('app', 'Company account').'</strong></p>'):('')) ?>
                            <p><?= Yii::t('app', 'Club member since') ?> <?= Yii::app()->locale->dateFormatter->format('yyyy', $model->owner->createtime); ?></p>
                            <p><?= Yii::t('app', 'From') ?> <strong><?= $model->owner->profile->fullCity ?></strong></p>
                            <p><?= Yii::t('app', 'Total offered') ?>: <?= CHtml::link($this->plural(count($model->owner->activeOffers), Yii::t('app', 'item1'), Yii::t('app', 'items2'), Yii::t('app', 'items5')), $model->owner->profileUrl) ?></p>
                            <p><?= CHtml::link('<i class="fa fa-envelope-o fa-fw"></i>'.Yii::t('app', 'Send message'), array('/user/privateMessages/dialog', 'id' => $model->id)) ?></p>
                        </div>
                        <?= SiteVars::v('VIEW_LIKES') ?>
                    </div>  
                </div>  
                <div class="col-xs-12 col-sm-9 col-lg-10 offer-view-full">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4 offer-photo">
                            <a href="#" class="offer-fav <?php if ($is_favourite) echo 'fav-set'; ?>" data-id="<?= $model->id ?>" data-url="<?= Yii::app()->createAbsoluteUrl('/offers/default/addToFavourites'); ?>">
                                <i class="fa fa-heart-o"></i>
                                <i class="fa fa-heart"></i>
                            </a>
                            <?php if (!empty($model->primaryPhoto)) echo CHtml::link(CHtml::image(Yii::app()->request->hostInfo.'/resources/offers/600_'.$model->primaryPhoto->filename, '', array('class' => 'img-responsive')), Yii::app()->request->hostInfo.'/resources/offers/'.$model->primaryPhoto->filename, array('rel' => 'group', 'class' => 'fancybox')); ?>
                            <div class="row offer-photos-other">
                                <?php
                                if (!empty($model->photos)) {
                                    $overphotos = array();
                                    foreach ($model->photos as $key => $photo) {
                                        if ($key > 0 && $key < 6) {
                                            switch ($key) {
                                                case 3: $class = 'col-xs-4 col-sm-3 hidden-xs col-md-2'; break;
                                                case 4: $class = 'col-xs-4 col-sm-3 hidden-sm hidden-xs col-md-2'; break;
                                                case 5: $class = 'col-xs-4 col-sm-3 hidden-sm hidden-xs col-md-2'; break;
                                                default: $class = 'col-xs-4 col-sm-3 col-md-2'; break;
                                            }
                                            echo '<div class="'.$class.'">';
                                            echo CHtml::link(
                                                    CHtml::image(Yii::app()->request->hostInfo.'/resources/offers/200_'.$photo->filename, '', array('class' => 'img-responsive')),
                                                    Yii::app()->request->hostInfo.'/resources/offers/'.$photo->filename, 
                                                    array('rel' => 'group', 'class' => 'fancybox')
                                                );
                                            echo '</div>';
                                        } elseif ($key >= 6) 
                                            $overphotos[] = $photo;
                                    }
                                    
                                    if (count($overphotos) == 1) {
                                        echo '<div class="col-xs-4 col-sm-3 col-md-2">';
                                        echo CHtml::link(
                                                CHtml::image(Yii::app()->request->hostInfo.'/resources/offers/200_'.$overphotos[0]->filename, '', array('class' => 'img-responsive')),
                                                Yii::app()->request->hostInfo.'/resources/offers/'.$overphotos[0]->filename, 
                                                array('rel' => 'group', 'class' => 'fancybox')
                                            );
                                        echo '</div>';
                                    } elseif (count($overphotos) > 1) {
                                        echo '<div class="col-xs-4 col-sm-3 col-md-2">';
                                        echo CHtml::link(
                                                CHtml::image(Yii::app()->request->hostInfo.'/resources/offers/200_'.$overphotos[0]->filename, '', array('class' => 'img-responsive')),
                                                Yii::app()->request->hostInfo.'/resources/offers/'.$overphotos[0]->filename, 
                                                array('rel' => 'group', 'class' => 'fancybox photo-under')
                                            );
                                        echo CHtml::link(
                                                CHtml::image(Yii::app()->theme->baseUrl.'/img/offer-photos-more.png', '', array('class' => 'img-responsive')),
                                                Yii::app()->request->hostInfo.'/resources/offers/'.$overphotos[0]->filename, 
                                                array('rel' => 'group', 'class' => 'fancybox photo-over')
                                            );
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                            
                            <?php if (!empty($model->video_link)) echo CHtml::link('<i class="fa fa-youtube-play fa-fw"></i> '.Yii::t('app', 'Watch video'), $model->video_link, array('class' => 'btn btn-danger btn-block fancybox.iframe video-fancybox', 'rel' => 'group1')) ?>

                            <?php
                            if (!empty($model->parameters) && count($model->parameters) < 10) {
                            ?>
                            <div class="row offer-about">
                                <div class="col-xs-12">
                                    <table class="table table-striped">
                                        <?php
                                        foreach ($model->parameters as $parameter) {
                                            echo '<tr><td class="parameter-title col-xs-4">'.$parameter->parameter->name.':</td><td>'.$parameter->value.'</td></tr>';
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>  
                            <?php
                            } elseif (!empty($model->parameters)) {
                            ?>
                            <div class="row offer-about">
                                <div class="col-xs-12">
                                    <?php                                         
                                    $this->widget('application.components.widgets.feMap', array(
                                        'pins'=>$pins,
                                        'height' => '200'
                                    ));
                                    ?>
                                    <p class="text-right">
                                        <?php 
                                        if (!empty($model->addresses))
                                            foreach ($model->addresses as $address) {
                                                echo '<em>'.$address->getFullAddress(true).'</em><br />';
                                            }
                                        ?>                                        
                                    </p>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>  
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <h1><?= $model->title ?> <span class="text-muted">[<?= $model->year ?>]</span></h1>

                            <div class="offer-rating">
                                <?php $this->widget('application.components.widgets.feRatingStars', array(
                                    'rating'=>$model->rating,
                                    'htmlOptions'=>array('class' => 'star-rating-small'),
                                )); ?>
                                from <?= $this->plural(count($model->reviews), Yii::t('app', 'client1'), Yii::t('app', 'clients2'), Yii::t('app', 'clients5')); ?>
                            </div>

                            <p><?= $model->description ?></p>

                            <?php
                            if (!empty($model->parameters) && count($model->parameters) < 10 || empty($model->parameters)) {
                            ?>
                            <div class="row offer-about">
                                <div class="col-xs-12">
                                    <?php                                         
                                    $this->widget('application.components.widgets.feMap', array(
                                        'pins'=>$pins,
                                        'height' => '250'
                                    ));
                                    ?>
                                    <p class="text-right">
                                        <?php 
                                        if (!empty($model->addresses))
                                            foreach ($model->addresses as $address) {
                                                echo '<em>'.$address->getFullAddress(true).'</em><br />';
                                            }
                                        ?>                                        
                                    </p>
                                </div>
                            </div> 
                            <?php
                            } elseif (!empty($model->parameters)) {
                            ?> 
                            <div class="row offer-about">
                                <div class="col-xs-12 col-sm-6">
                                    <table class="table table-striped">
                                        <?php
                                        foreach ($model->parameters as $key => $parameter) {
                                            if ($key % 2 == 0)
                                                echo '<tr><td class="parameter-title col-xs-4">'.$parameter->parameter->name.':</td><td>'.$parameter->value.'</td></tr>';
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <table class="table table-striped">
                                        <?php
                                        foreach ($model->parameters as $key => $parameter) {
                                            if ($key % 2 == 1)
                                                echo '<tr><td class="parameter-title col-xs-4">'.$parameter->parameter->name.':</td><td>'.$parameter->value.'</td></tr>';
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>  
                            <?php
                            }
                            ?> 

                            <hr class="dotted-line" />

                            <div class="row hidden-xs">
                                <div class="col-xs-12 col-sm-4 text-center">
                                    <a href="#offer-tabs" data-target="offer-tabs" data-tab="offer-reviews" class="smooth-tab dashed"><?= Yii::t('app', 'Reviews') ?></a>
                                </div>
                                <div class="col-xs-12 col-sm-4 text-center">
                                    <a href="#offer-tabs" data-target="offer-tabs" data-tab="offer-comments" class="smooth-tab dashed"><?= Yii::t('app', 'Comments') ?></a>
                                </div>
                                <div class="col-xs-12 col-sm-4 text-center">
                                    <a href="#offer-tabs" data-target="offer-tabs" data-tab="offer-faq" class="smooth-tab dashed"><?= Yii::t('app', 'Questions & Answers') ?></a>
                                </div>
                            </div> 
                        </div> 
                    </div>
                </div>  
            </div>  
            
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-lg-2">
                    <?= SiteVars::v('BODY_LIKES'); ?>
                </div>  
                <div class="col-xs-12 col-sm-9 col-lg-10">
                    <h5><?= Yii::t('app', 'Rental Information') ?></h5>
                    <?= $model->rental_information ?>
                    
                    <?php if (!empty($model->publicOptions)) { ?>
                    <h3><?= Yii::t('app', 'Additional Options') ?></h3>
                    <?php } ?>
                    
                    <form action="<?= Yii::app()->createAbsoluteUrl('/offers/default/order', array('id' => $model->id)) ?>" method="POST" id="additional-options-form">
                        <?php if (!empty($model->publicOptions)) { ?>                        
                        <div class="row">
                            <?php
                            foreach ($model->publicOptions as $key => $option) {
                                if ($key < 2)
                                    $this->renderPartial('/offerOptions/_view', array('data' => $option));
                            }
                            
                            if (count($model->publicOptions) > 2) {
                            ?>
                            <div class="options-extended-link">
                                <span class="open-link">
                                    <i class="fa fa-angle-down"></i> <a href="#" class="dashed"><?= Yii::t('app', 'Show all options') ?></a> <i class="fa fa-angle-down"></i>
                                </span>
                                <span class="close-link">
                                    <i class="fa fa-angle-up"></i> <a href="#" class="dashed"><?= Yii::t('app', 'Hide all options') ?></a> <i class="fa fa-angle-up"></i>
                                </span>
                            </div>
                            <div class="options-extended">
                            <?php
                            foreach ($model->publicOptions as $key => $option) {
                                if ($key >= 2)
                                    $this->renderPartial('/offerOptions/_view', array('data' => $option));
                            }
                            ?>
                            </div>
                            <?php } ?>
                        </div>

                        <br />
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-3 text-success">
                                <div class="options-result" data-currency="<?= Yii::app()->params['currency']['name'] ?>">
                                    <?= $this->formatPrice(0, '+ '); ?>
                                    <!--+ $<span id="options-calc-result">0</span>-->
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <a href="#" class="btn btn-success btn-submit btn-block btn-solid" data-target="additional-options-form"><?= Yii::t('app', 'Add to Order') ?> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                        <?php } ?>
                    </form>
                    
                    <ul class="nav nav-tabs offer-nav" id="offer-tabs" role="tablist">
                        
                        <li role="presentation" class="active"><a href="#offer-reviews" aria-controls="offer-reviews" role="tab"><?= Yii::t('app', 'Reviews') ?> (<?= count($model->reviews); ?>)</a></li>
                        <li role="presentation"><a href="#offer-comments" aria-controls="offer-comments" role="tab"><?= Yii::t('app', 'Comments') ?> (<?= count($model->comments); ?>)</a></li>
                        <li role="presentation"><a href="#offer-faq" aria-controls="offer-faq" role="tab"><?= Yii::t('app', 'FAQ') ?> (<?= count($model->faq); ?>)</a></li>
                    </ul>
                    
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="offer-reviews">
                            <?php
                            if (!empty($model->reviews))
                                foreach ($model->reviews as $review) {
                                    $this->renderPartial('/offerReviews/_view', array('data' => $review));
                                }
                            ?>                            
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="offer-comments">
                            <?php
                            if (!empty($model->topComments))
                                $this->renderPartial('/offerComments/_treeview', array('comments' => OfferComments::getTree($model->id)));
                            ?>   
                            
                            <div class="row">
                                <div class="col-xs-12 col-md-8">
                                    <h4><?= Yii::t('app', 'Leave your comment') ?>:</h4>
                            
                                    <form action="" method="POST" id="form-root">
                                        <div class="form-group">
                                            <label for="abc" class="control-label"><?= Yii::t('app', 'Your message') ?>:</label>
                                            <textarea name="comment_text" class="form-control" rows="5"></textarea>
                                            <?= CHtml::hiddenField('parent_id', 0); ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" class="icheck" id="send-as-private"> <label for="send-as-private" class="control-label"><?= Yii::t('app', 'Send as private message') ?></label>
                                        </div>
                                        <div class="form-group">
                                            <a href="#" class="btn btn-submit btn-success" data-target="form-root"><?= Yii::t('app', 'Submit') ?></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="offer-faq">
                            <?php
                            if (!empty($model->faq))
                                foreach ($model->faq as $faq) {
                                    $this->renderPartial('/offerFaq/_view', array('data' => $faq));
                                }
                            ?>          
                        </div>
                    </div>
                    
                    
                    <?php
                    if (!empty($model->similarOffers)) {
                    ?>
                    <br />
                    <h3><?= Yii::t('app', 'Similar Offers around') ?></h3>
                    <br />
                    <div class="row">
                        <?php
                            foreach ($model->similarOffers as $key => $similar) {
                                if ($key == 3)
                                    $class = 'col-xs-12 col-sm-4 hidden-sm col-md-3';
                                else
                                    $class = 'col-xs-12 col-sm-4 col-md-3';
                                echo '<div class="'.$class.'">';
                                $this->renderPartial('_view', array('data' => $similar));
                                echo '</div>';
                            }
                        ?>
                    </div>
                    <?php
                    }
                    
                    //First address
                    if (!empty($model->addresses)) {
                        $first_address_obj = $model->addresses[0];
                        $first_address = $first_address_obj->getFullAddress(true);
                        
                        echo '<br />';
                        echo '<div class="text-center">';
                        echo CHtml::link(Yii::t('app', 'Get more similar offers').' <i class="fa fa-angle-right"></i>', array('/site/search', 'l' => $first_address), array('class' => 'btn btn-default'));
                        echo '</div>';
                    }                      
                    ?>
                </div>  
            </div>  
        </div>  