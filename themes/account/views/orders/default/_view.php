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
            <?= CHtml::link(CHtml::image($img_src, $offer->title, array('class' => 'img-responsive')), array('/orders/default/edit', 'id' => $data->id)) ?>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-5">
            <h4>
                <?= CHtml::link($offer->title, array('/orders/default/edit', 'id' => $data->id)) ?>
                <?php
                if ($data->status == Orders::STATUS_NEW) {
                    echo '&nbsp;&nbsp;';
                    echo CHtml::link('<i class="fa fa-pencil"></i>', array('/orders/default/edit', 'id' => $data->id), array('class' => 'text-default'));
                }
                ?>
            </h4>
            <p class="offer-view-client"><?= Yii::t('app', 'offered by') ?> <?= CHtml::link($owner->name, array('/user/profile/view', 'id' => $owner->user_id)) ?></p>
            <p><span class="text-muted">
                <?= Yii::t('app', 'Total').': '.$this->formatPrice($data->cleanCost) ?>
                <?php
                if ($data->discount > 0)
                    echo '<sup class="text-danger">-'.$data->discount.'%</sup>';
                ?>
            </span></p>
            <p class="price-block">
                <?= Yii::t('app', 'To pay:') ?> <?= $this->formatPrice($data->total_cost) ?>
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
            
            if (!empty($data->notes)) {
                echo '<br /><p class="text-serif text-thick"><big>'.Yii::t('app', 'Notes').'</big></p>';
                echo '<p>'.$data->notes.'</p>';
            }
            ?>
        </div>
        <div class="col-xs-12 col-md-5 col-lg-4">
             <div class="order-details">
                <div class="row">
                    <div class="col-xs-12 col-sm-5 center-block">
                        <h5><?= Yii::t('app', 'Ordered') ?></h5>
                        <big><?= Yii::app()->locale->dateFormatter->format("d", $data->date_changed) ?></big>
                        <p><?= Yii::app()->locale->dateFormatter->format("MMM, yyyy", $data->date_changed) ?></p>
                        <p><small><?= Yii::app()->locale->dateFormatter->format("H:mm", $data->date_changed) ?></small></p>
                    </div>
                   <!--  <div class="col-xs-12 col-sm-2">
                        <span class="date-between">~</span>
                    </div> -->        
                </div>
            </div>
            <br />
            <div class="row">
                <?php
                if ($data->status != Orders::STATUS_APPROVED) {
                ?>
                <div class="col-xs-8">
                    <?php                        
                        if ($data->status == Orders::STATUS_NEW)
                            echo CHtml::link(Yii::t('app', 'Submit order'), array('/orders/default/setStatus', 'id' => $data->id, 's' => Orders::STATUS_SUBMITTED), array('class' => 'btn btn-success btn-solid btn-block'));
                        elseif ($data->status == Orders::STATUS_SUBMITTED)
                            echo '<p class="text-muted text-center"><small>'.Yii::t('app', 'Waiting for owner submit...').'</small></p>';
                        elseif ($data->status == Orders::STATUS_PAYMENT)
                            echo CHtml::link(Yii::t('app', 'Pay'), array('/orders/default/pay', 'id' => $data->id), array('class' => 'btn btn-primary btn-solid btn-block'));
                        //elseif ($data->status == Orders::STATUS_APPROVED)
                        //    echo CHtml::link(Yii::t('app', 'Release Payment'), array('/orders/default/setStatus', 'id' => $data->id, 's' => Orders::STATUS_SUCCESSFUL), array('class' => 'btn btn-success btn-solid btn-block'));
                    ?>
                </div>
                <div class="col-xs-4">
                    <?= CHtml::link(Yii::t('app', '<i class="fa fa-times"></i>'), array('/orders/default/setStatus', 'id' => $data->id, 's' => Orders::STATUS_CANCELED), array('class' => 'btn btn-muted btn-block btn-icon', 'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'))) ?>
                </div>
                <?php
                } else {
                ?>
                <div class="col-xs-12">
                    <?php
                        echo '<h5>'.Yii::t('app', 'Release code: ').'</h5>';
                        echo '<span class="order-release-code">'.$data->release_code.'</span>';
                    ?>
                </div>
                <?php
                }
                ?>
            </div>
            <br />
            <div class="row">
                <?php
                if ($data->status == Orders::STATUS_APPROVED) {
                ?>
                <div class="col-xs-4 col-xs-offset-8">
                    <?= CHtml::link(Yii::t('app', '<i class="fa fa-times"></i>'), array('/orders/default/setStatus', 'id' => $data->id, 's' => Orders::STATUS_CANCELED), array('class' => 'btn btn-muted btn-block btn-icon', 'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'))) ?>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        
        <hr />
    </div>

