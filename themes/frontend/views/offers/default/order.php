<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Search') => array('/site/search'),
    $model->offer->title => array('/offers/default/view', 'id'=>$model->offer_id),
    Yii::t('app', 'Order form')
);

$this->pageTitle = Yii::t('app', 'Order form');

if (!empty($model->offer->primaryPhoto))
    $img_src = Yii::app()->request->hostInfo.'/resources/offers/200_'.$model->offer->primaryPhoto->filename;
else
    $img_src = Yii::app()->theme->baseUrl.'/img/blank_offer.png';

?>

<div class="container top-block">
    <div class="row">
        <div class="col-xs-12 col-sm-9 col-sm-offset-3">
            <h3><?= Yii::t('app', 'New order') ?></h3>
            <br />
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12 col-sm-3">
            <div class="offer-view-lite">
                <?= CHtml::link(CHtml::image($img_src, $model->offer->title, array('class' => 'img-responsive')), array('/offers/default/view', 'id' => $model->offer_id)) ?>
                <h4><?= CHtml::link($model->offer->title, array('/offers/default/view', 'id' => $model->offer_id)) ?></h4>
                <?php $this->widget('application.components.widgets.feRatingStars', array(
                    'rating'=>$model->offer->rating,
                    'htmlOptions'=>array('class' => 'star-rating-small'),
                )); ?>
                <br />
                <p class="offer-price"><?= $this->formatPrice($total_cost); ?></p>
                <?php

                if(!empty($mo->additions[0])){
                    $wh=$mo->additions[0];

                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?php
                        if(!empty($wh['mon'])){
                        ?>
                        <div class="row">
                            <p><span>Mon: </span><?=$wh['mon'];?></p>
                        </div>
                        <?php
                        }                                   
                        if(!empty($wh['tue'])){
                        ?>
                        <div class="row">
                            <p><span>Tue: </span><?=$wh['tue'];?></p>
                        </div>
                        <?php
                        }
                        if(!empty($wh['wed'])){
                        ?>
                        <div class="row">
                            <p><span>Wed: </span><?=$wh['wed'];?></p>
                        </div>
                        <?php
                        }
                        if(!empty($wh['thu'])){
                        ?>
                        <div class="row">
                            <p><span>Thu: </span><?=$wh['thu'];?></p>
                        </div>
                        <?php
                        }
                        if(!empty($wh['fri'])){
                        ?>
                        <div class="row">
                            <p><span>Fri: </span><?=$wh['fri'];?></p>
                        </div>
                        <?php
                        }                        
                        if(!empty($wh['sat'])){
                        ?>
                        <div class="row">
                            <p><span>Sat: </span><?=$wh['sat'];?></p>
                        </div>
                        <?php
                        }
                        if(!empty($wh['sun'])){
                        ?>
                        <div class="row">
                            <p><span>Sun: </span><?=$wh['sun'];?></p>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9">    
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'offer-documents-form',
                'enableAjaxValidation'=>false,
                'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'')
            )); ?>

                <?php echo $form->errorSummary($model); ?>

                <?php /*
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'date_since'); ?>
                            <?php $this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_since')); ?>
                            <span class="help-block m-b-none"><?php echo $form->error($model,'date_since'); ?></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'date_for'); ?>
                            <?php $this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_for')); ?>
                            <span class="help-block m-b-none"><?php echo $form->error($model,'date_for'); ?></span>
                        </div>
                    </div>
                </div>
                 * 
                 */ ?>
            
               <!-- <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'dates_split'); ?>
                            <div id="order-dates-container">
                                <span class="date-icon"><i class="fa fa-calendar text-default"></i></span><?php echo $form->textField($model,'dates_split',array('class'=>'', 'placeholder' => 'Set actual dates...', 'id' => 'order-dates', 'data-offer-id' => $model->offer_id)); ?>
                            </div>
                            <span class="help-block m-b-none"><?php echo $form->error($model,'dates_split'); ?></span>
                        </div>
                        
                        <div id="order-dates-result"></div>
                    </div>
                </div>
-->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 offer-view-full">
                        <h1 style="margin-bottom: 20px;"><?php echo $mo['title'];?></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'amount'); ?>
                            <?php echo $form->textField($model,'amount',array('class'=>'form-control')); ?>
                        </div>
                        <?php if (!empty($model->offer->publicOptions)) { ?>
                        <h4><?= Yii::t('app', 'Additional Options') ?></h4>
                        <div class="form-group">
                            <div class="checkbox ">
                                <?php 
                                    foreach($mo->additions as $i =>$addi){ 
                                        if(in_array($addi['id'],$a_options))
                                            echo CHtml::HiddenField('OfferOptions['.$addi['id'].']',$addi['id']); 
                                       
                                           $hopt=array(
                                            'disabled'=>true,
                                            'value'=>$addi['id'],
                                            'style'=>!$i?'display: none;':'',
                                            'readonly'=>true,
                                            'id'=>'offeroption'.$addi['id'],
                                            'class'=>'calcOptions',
                                            'data-alter-price'=>'',
                                            'data-price'=>$addi['price_daily'],
                                            ); 
                                            echo CHtml::CheckBox('OfferOptions['.$addi['id'].']', in_array($addi['id'],$a_options),$hopt); 
                                            echo CHtml::label($addi['title'],'OfferOptions['.$addi['id'].']').'<br />';
                                        
                                    }
                                ?>
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                
                <!-- <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'address_from'); ?>
                            <?php echo $form->dropDownList($model,'address_from',$model->offer->getAddressesList(),array('class'=>'form-control')); ?>
                            <span class="help-block m-b-none"><?php echo $form->error($model,'address_from'); ?></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'address_to'); ?>
                            <?php echo $form->dropDownList($model,'address_to',$model->offer->getAddressesList(),array('class'=>'form-control')); ?>
                            <span class="help-block m-b-none"><?php echo $form->error($model,'address_to'); ?></span>
                        </div>
                    </div>
                </div> -->
                

                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'notes'); ?>
                        <?php echo $form->textArea($model,'notes',array('class'=>'form-control', 'rows'=>7)); ?>
                        <span class="help-block m-b-none"><?php echo $form->error($model,'notes'); ?></span>
                    </div>
                    <br />
                    <div class="form-group">
                        <button class="btn btn-success" type="submit"><?= Yii::t('app', 'Continue') ?><i class="fa fa-angle-right"></i></button>
                    </div>
                </div>
            </div>

                
                

            <?php $this->endWidget(); ?>
        </div>
    </div>    
</div>