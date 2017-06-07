<?php
    $this->pageTitle = Yii::t('app', 'Order #').$model->id.' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'Profile Edit') => array('/user/profile/edit'),
        Yii::t('app', 'My Orders') => array('/orders/default/index'),
        Yii::t('app', 'Order #').$model->id
    );

    $offer = $model->offer;
    $owner = $model->offer->owner->profile;
    
    if (!empty($offer->primaryPhoto))
        $img_src = Yii::app()->request->hostInfo.'/resources/offers/400_'.$offer->primaryPhoto->filename;
    else
        $img_src = Yii::app()->theme->baseUrl.'/img/blank_offer.png';
    
    switch ($model->status) {
        case Orders::STATUS_NEW: $status_line = '<span class="text-muted">'.Yii::t('app', 'Status').':&nbsp;'.Yii::t('app', 'New').'</span>'; break;
        case Orders::STATUS_APPROVED: $status_line = '<span class="text-default">'.Yii::t('app', 'Status').':&nbsp;'.Yii::t('app', 'Approved').'</span>'; break;
        case Orders::STATUS_PAID: $status_line = '<span class="text-success">'.Yii::t('app', 'Status').':&nbsp;'.Yii::t('app', 'Paid').'</span>'; break;
        case Orders::STATUS_SUCCESS: $status_line = '<span class="text-muted">'.Yii::t('app', 'Status').':&nbsp;'.Yii::t('app', 'Finished').'</span>'; break;
        case Orders::STATUS_CANCELED: $status_line = '<span class="text-danger">'.Yii::t('app', 'Status').':&nbsp;'.Yii::t('app', 'Canceled').'</span>'; break;
    }
?>

    <div class="account-content">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <h3 class="order-title"><?= Yii::t('app', 'Order #').$model->id.$status_line ?></h3>
            </div>
        </div>
        
        <div class="row order-view">
            <div class="col-xs-12 col-sm-4 col-md-2 col-lg-3">
                <?= CHtml::image($img_src, $offer->title, array('class' => 'img-responsive')) ?>
                <p class="order-controls">
                    <?= CHtml::link('<i class="fa fa-pencil"></i>'.Yii::t('app', 'Edit order details'), array('/orders/default/edit', 'id' => $model->id), array('class' => 'text-default')) ?>
                    <?= CHtml::link('<i class="fa fa-times"></i>'.Yii::t('app', 'Decline order'), array('/orders/default/delete', 'id' => $model->id), array('class' => 'text-danger', 'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'submit' => array('delete', 'id' => $model->id), 'params' => array('id' => $model->id))) ?>
                </p>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-5">
                <h4><?= $offer->title ?></h4>
                <p class="offer-view-client"><?= Yii::t('app', 'offered by') ?> <?= CHtml::link($owner->name, array('/user/profile/view', 'id' => $owner->user_id)) ?></p>
                <p class="price-block"><?= Yii::t('app', 'Total') ?>: <?= $this->formatPrice($model->total_cost) ?></p>
                <p>
                    <span class="text-muted"><?= Yii::t('app', 'From') ?>:</span> <?= $model->addressFrom->address->getFullAddress(true) ?> <i class="fa fa-map-marker"></i><br />
                    <span class="text-muted"><?= Yii::t('app', 'To') ?>:</span> <?= $model->addressTo->address->getFullAddress(true) ?> <i class="fa fa-map-marker"></i>
                </p>                
                <?php
                if (!empty($model->options)) {
                    echo '<br /><p class="text-serif text-thick"><big>'.Yii::t('app', 'Additional Options').'</big></p>';
                    echo '<ul>';
                    foreach ($model->options as $option) {
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
                            <big><?= Yii::app()->locale->dateFormatter->format("d", $model->date_since) ?></big>
                            <p><?= Yii::app()->locale->dateFormatter->format("MMM, yyyy", $model->date_since) ?></p>
                            <p><small><?= Yii::app()->locale->dateFormatter->format("H:mm", $model->date_since) ?></small></p>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <span class="date-between">~</span>
                        </div>
                        <div class="col-xs-12 col-sm-5">
                            <h5><?= Yii::t('app', 'Return') ?></h5>
                            <big><?= Yii::app()->locale->dateFormatter->format("d", $model->date_for) ?></big>
                            <p><?= Yii::app()->locale->dateFormatter->format("MMM, yyyy", $model->date_for) ?></p>
                            <p><small><?= Yii::app()->locale->dateFormatter->format("H:mm", $model->date_for) ?></small></p>
                        </div>
                    </div>
                    <p class="text-center total-days"><?= Yii::t('app', 'total') ?> <?= $this->plural($model->daysDifference, Yii::t('app', 'day'), Yii::t('app', 'days2'), Yii::t('app', 'days5')) ?></p>
                </div>
            </div>
        </div>          
    </div>