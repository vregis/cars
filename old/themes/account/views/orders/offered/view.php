<?php
/* @var $this UserDocumentsController */
/* @var $model UserDocuments */

    $this->pageTitle = Yii::t('app', 'Order #').$model->id.' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'Orders Schedule') => array('/orders/offered/index'),
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
        <h3>
            <?php
                echo Yii::t('app', 'Order #').$model->id;
                
                echo '<span class="order-status-label '.$model->statusClass.'">'.Yii::t('app', $model->statuses[$model->status]).'</span>';
            ?>
        </h3>
        
        <br />

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'offer-documents-form',
            'enableAjaxValidation'=>false,
            'htmlOptions' => array('class'=>'')
        )); ?>

            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <h5 class="order-labels"><?= $model->getAttributeLabel('client_id'); ?></h5>
                    <h5>
                    <?php 
                        echo $model->client->profile->name;
                        echo '&nbsp;&nbsp;&nbsp;';
                        echo CHtml::link('<i class="fa fa-user"></i>', array('/user/profile/view', 'id' => $model->client_id));
                        echo '&nbsp;&nbsp;&nbsp;';
                        echo CHtml::link('<i class="fa fa-envelope-o"></i>', array('/user/privateMessages/dialog', 'id' => $model->client_id));
                    ?>
                    </h5>
                    <p class="text-muted"><?= $model->client->profile->fullCity ?></p>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <h5 class="order-labels"><?= $model->getAttributeLabel('total_cost'); ?></h5>
                    <h5>
                    <?php 
                        echo $this->formatPrice($model->total_cost);
                    ?>
                    </h5>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <h5 class="order-labels"><?= $model->getAttributeLabel('date_since'); ?></h5>
                    <p><?= Yii::app()->locale->dateFormatter->format(Yii::t("app", "d MMM yyyy, в H:mm"), $model->date_since) ?></p>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <h5 class="order-labels"><?= $model->getAttributeLabel('date_for'); ?></h5>
                    <p><?= Yii::app()->locale->dateFormatter->format(Yii::t("app", "d MMM yyyy, в H:mm"), $model->date_for) ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <h5 class="order-labels"><?= $model->getAttributeLabel('address_from'); ?></h5>
                    <p><?= $model->addressFrom->address->fullAddress ?></p>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <h5 class="order-labels"><?= $model->getAttributeLabel('address_to'); ?></h5>
                    <p><?= $model->addressTo->address->fullAddress ?></p>
                </div>
            </div>
            
            <?php 
            if (!empty($model->options)) {
                echo '<h5 class="order-labels">'.Yii::t('app', 'Additional Options').'</h5>';
                
                echo '<ul>';
                foreach ($model->options as $option) {
                    echo '<li>'.$option->title.'</li>';                    
                }
                echo '</ul>';
            }
            ?>

            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <?php
                        if ($model->status == Orders::STATUS_SUBMITTED) {
                    ?>
                    
                    <h5 class="order-labels"><?= $model->getAttributeLabel('discount'); ?></h5>
                    <?php echo $form->textField($model,'discount',array('class'=>'form-control')); ?>?>
                    
                    <h5 class="order-labels"><?= $model->getAttributeLabel('notes'); ?></h5>
                    <?php echo $form->textArea($model,'notes',array('class'=>'form-control', 'rows' => 7)); ?>
                    
                    <?php
                        } elseif ($model->status < Orders::STATUS_APPROVED) {
                    ?>
                    
                    <h5 class="order-labels"><?= $model->getAttributeLabel('discount'); ?></h5>
                    <p><?= $model->discount.'%' ?></p>
                    
                    <h5 class="order-labels"><?= $model->getAttributeLabel('notes'); ?></h5>
                    <p><?= $model->notes ?></p>
                    
                    <?php
                        } elseif ($model->status == Orders::STATUS_APPROVED) {
                    ?>
                    
                    <h5 class="order-labels"><?= $model->getAttributeLabel('release_code'); ?></h5>
                    <?php echo CHtml::textField('release_code','',array('class'=>'form-control')); ?>
                    <?php if (isset($_POST['release_code'])) echo '<span class="text-danger">'.Yii::t('app', 'Wrong Release code!').'</span>'; ?>
                    
                    <?php
                        }
                    ?>
                                        
                    <br /><br />
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <?php
                        if ($model->status == Orders::STATUS_SUBMITTED) 
                            echo '<button class="btn btn-primary" type="submit">'.Yii::t('app', 'Save changes').'</button>';
                        elseif ($model->status == Orders::STATUS_APPROVED) 
                            echo '<button class="btn btn-success btn-solid" type="submit">'.Yii::t('app', 'Release code').'</button>';
                    ?>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <?php
                        if ($model->status == Orders::STATUS_SUBMITTED) 
                            echo CHtml::link(Yii::t('app', 'Approve order'), array('/orders/default/setStatus', 'id' => $model->id, 's' => Orders::STATUS_PAYMENT), array('class' => 'btn btn-block btn-solid btn-success'));
                    ?>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <?php if ($model->status < Orders::STATUS_APPROVED) CHtml::link(Yii::t('app', 'Cancel order'), array('/orders/default/setStatus', 'id' => $model->id, 's' => Orders::STATUS_CANCELED), array('class' => 'btn btn-block btn-muted')) ?>
                </div>                
            </div>

        <?php $this->endWidget(); ?>
        
        <br /><br />
            
        <hr />
        
        <br />
        
        <h3><?= Yii::t('app', 'Offer information') ?></h3>
        
        <div class="row order-view">
            <div class="col-xs-12 col-sm-4 col-md-3">
                <?= CHtml::link(CHtml::image($img_src, $offer->title, array('class' => 'img-responsive')), array('/offers/default/view', 'id' => $model->offer_id)) ?>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-9">
                <h4><?= CHtml::link($offer->title, array('/offers/default/view', 'id' => $model->offer_id)) ?></h4>
                <p class="offer-view-client"><?= Yii::t('app', 'ordered by') ?> <?= CHtml::link($model->client->profile->name, array('/user/profile/view', 'id' => $model->client_id)) ?></p>
                
                <h5><?= Yii::t('app', 'Rental Information') ?></h5>
                <?= $model->offer->rental_information ?>
            </div>
        </div>   
    </div>  