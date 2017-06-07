<?php
    /* @var $this OfferDocumentsController */
    /* @var $model OfferDocuments */

    $this->pageTitle = Yii::t('app', 'Offer Blocking').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'Offer #').$offer->id => array('/offers/default/edit', 'id' => $offer->id),
        Yii::t('app', 'Offer Blocking')
    );
    
    $prev_date = new DateTime($date_since->format('Y-m-d'));
    $next_date = new DateTime($date_since->format('Y-m-d'));
    $prev_date = $prev_date->sub(new DateInterval('P1M'))->format('Y-m-d');
    $next_date = $next_date->add(new DateInterval('P1M'))->format('Y-m-d');

    $this->renderPartial('/default/_tabs', array('model' => $offer));   
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Offer Blocking') ?></h3> 
        <br />
        
        <div class="row">
            <div class="col-xs-12 col-sm-8 text-center">
                <?= CHtml::link('<i class="fa fa-angle-left"></i>', array('index', 'id' => $offer->id, 's' => $prev_date), array('class'=>'btn btn-muted btn-icon')) ?>
                <span class="btn-aligned"><?= $date_since->format('F, Y') ?> &ndash; <?= $date_for->format('F, Y') ?></span>
                <?= CHtml::link('<i class="fa fa-angle-right"></i>', array('index', 'id' => $offer->id, 's' => $next_date), array('class'=>'btn btn-muted btn-icon')) ?>
            </div>
            <div class="col-xs-12 col-sm-4 text-right">
                <?= CHtml::link(Yii::t('app', '+ Add new blocked period'), '#', array('class'=>'btn btn-success btn-solid btn-add-block', 'data-url' => $this->createAbsoluteUrl('/offers/offerBlocks/add', array('id' => $offer->id)))) ?>
            </div>
        </div>       
        
        <br /><br />
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <h5 class="text-center"><?= $date_since->format('F, Y') ?></h5>
                <?= OfferBlocks::buildCalendar($date_since->format('m'), $date_since->format('Y'), $blocks) ?>
            </div>
            <div class="col-xs-12 col-sm-4">
                <h5 class="text-center"><?= $date_for->format('F, Y') ?></h5>
                <?= OfferBlocks::buildCalendar($date_for->format('m'), $date_for->format('Y'), $blocks) ?>
            </div>
            <div class="col-xs-12 col-sm-4 daily-schedule" data-url="<?= $this->createAbsoluteUrl('/offers/offerBlocks/daySchedule', array('offer_id' => $offer->id)) ?>">
                <?= $this->renderPartial('_day', array('blocks' => $blocks)) ?>              
            </div>
        </div>
        
        <br /><br />
        <p class="text-right">
        <?php if ($offer->status == Offers::STATUS_PASSIVE) echo CHtml::link(Yii::t('app', 'Continue').' <i class="fa fa-angle-right"></i>', array('/offers/offersParameterValues/index', 'id' => $offer->id), array('class' => 'btn btn-success')) ?>
        </p>
    </div>