<?php
/* @var $this OfferOptionsController */
/* @var $model OfferOptions */

    $this->pageTitle = Yii::t('app', 'Add Addition').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'Offer #').$model->offer_id => array('/offers/default/edit', 'id' => $model->offer_id),
        Yii::t('app', 'Offer Options') => array('/offers/offerOptions/index', 'id' => $model->offer_id),
        Yii::t('app', 'Add Addition')
    );

    $this->renderPartial('/default/_tabs', array('model' => $model->offer));  
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Add Addition') ?></h3>
        
        <?php

            $this->renderPartial('_formaddition', array('model'=>$model));

        ?>
    </div>