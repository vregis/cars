<?php
/* @var $this UserDocumentsController */
/* @var $model UserDocuments */

    $this->pageTitle = Yii::t('app', 'Order #').$model->id.' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Orders') => array('/orders/default/index'),
        Yii::t('app', 'Order #').$model->id
    );

    $offer = $model->offer;
    $owner = $model->offer->owner->profile;
    
    if (!empty($offer->primaryPhoto))
        $img_src = Yii::app()->request->hostInfo.'/resources/offers/400_'.$offer->primaryPhoto->filename;
    else
        $img_src = Yii::app()->theme->baseUrl.'/img/blank_offer.png';
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Offer information') ?></h3>
        
        <div class="row order-view">
            <div class="col-xs-12 col-sm-4 col-md-3">
                <?= CHtml::image($img_src, $offer->title, array('class' => 'img-responsive')) ?>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-5">
                <h4><?= $offer->title ?></h4>
                <p class="offer-view-client"><?= Yii::t('app', 'offered by') ?> <?= CHtml::link($owner->name, array('/user/profile/view', 'id' => $owner->user_id)) ?></p>
                <p><span class="text-muted">
                    <?= Yii::t('app', 'Total').': '.$this->formatPrice($model->cleanCost) ?>
                    <?php
                    if ($model->discount > 0)
                        echo '<sup class="text-danger">-'.$model->discount.'%</sup>';
                    ?>
                </span></p>
                <p class="price-block">
                    <?= Yii::t('app', 'To pay:') ?> <?= $this->formatPrice($model->total_cost) ?>
                </p>
                
                <p>
                    <span class="text-muted"><?= Yii::t('app', 'From') ?>:</span> <?= $model->addressFrom->address->getFullAddress(true) ?> <i class="fa fa-map-marker"></i><br />
                    <span class="text-muted"><?= Yii::t('app', 'To') ?>:</span> <?= $model->addressTo->address->getFullAddress(true) ?> <i class="fa fa-map-marker"></i>
                </p>
            </div>
            <div class="col-xs-12 col-sm-4">
                <h5><?= Yii::t('app', 'Rental Information') ?></h5>
                <?= $model->offer->rental_information ?>
            </div>
            
            <hr />
        </div>   
        
        <br />
        
        <h4>
            <?php
                echo Yii::t('app', 'Order #').$model->id;
                
                echo '<span class="order-status-label '.$model->statusClass.'">'.Yii::t('app', $model->statuses[$model->status]).'</span>';
                
                
            ?>
        </h4>
        
        <?php
        if (!empty($model->release_code) && $model->status > Orders::STATUS_SUCCESSFUL) {
        ?>
        <br />
        
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-6">
                <h5>
                    <?php
                        echo Yii::t('app', 'Release code: ');

                        if ($model->status == Orders::STATUS_SUCCESSFUL)
                            echo '<span class="order-release-code">'.$model->release_code.'</span>';
                    ?>
                </h5>
            </div>  
        </div>  
        <?php } ?>
        
        <br />
        
        <?php
            $this->renderPartial('_form', array('model' => $model, 'a_options' => $a_options));    
        ?>
        
        <br />
        
        <?php
        if ($model->status == Orders::STATUS_SUCCESSFUL && (empty($model->userReviews) && empty($model->offerReviews))) 
            echo CHtml::link(Yii::t('app', 'Leave a Review').'<i class="fa fa-angle-right"></i>', array('/offers/offerReviews/add', 'id' => $model->id), array('class' => 'btn btn-primary btn-solid'));
        elseif (!empty($model->offerReviews)) {
            echo '<h5>'.Yii::t('app', 'Review for this order').'</h5><br />';
            $this->renderPartial('//offers/offerReviews/_view', array('order' => $model));    
        }
        ?>
    </div>