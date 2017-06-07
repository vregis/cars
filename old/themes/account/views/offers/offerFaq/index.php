<?php
    /* @var $this OfferFaqController */
    /* @var $model OfferFaq */

    $this->pageTitle = Yii::t('app', 'Offer FAQs').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'Offer #').$model->offer_id => array('/offers/default/edit', 'id' => $model->offer_id),
        Yii::t('app', 'Offer FAQs')
    );

    $this->renderPartial('/default/_tabs', array('model' => $model->offer));    
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Offer FAQs') ?></h3>
        
        <?php
            echo '<p class="text-right">'.CHtml::link(Yii::t('app', '+ Add new question'), array('add', 'id'=>$model->offer_id), array('class'=>'btn btn-success text-right')).'</p>';
            
            $this->renderPartial('indexgrid', array('model'=>$model));
        ?>
        
        
        <?php
        if ($model->offer->status == Offers::STATUS_PASSIVE) {
        ?>
        <br /><br />
        <p class="text-right">
        <?= CHtml::link(Yii::t('app', 'Finish & Activate Offer').' <i class="fa fa-angle-right"></i>', array('/offers/default/activate', 'id' => $model->offer_id), array('class' => 'btn btn-success')) ?>
        </p>
        <?php
        }
        ?>
    </div>