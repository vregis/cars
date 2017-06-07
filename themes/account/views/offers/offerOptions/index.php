<?php
    /* @var $this OfferOptionsController */
    /* @var $model OfferOptions */

    $this->pageTitle = Yii::t('app', 'Offer Options').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'Offer #').$model->offer_id => array('/offers/default/edit', 'id' => $model->offer_id),
        Yii::t('app', 'Prices')
    );

    $this->renderPartial('/default/_tabs', array('model' => $model->offer));    
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Prices') ?></h3>
        
        <?php
            echo '<p class="text-right">'.CHtml::link(Yii::t('app', 'New Price'), array('addmain', 'id'=>$model->offer_id, 'mo'=>0), array('class'=>'btn btn-success text-right')).'</p>';
            //here roma
            //var_dump($model);
            $model->main_option=1;
            $this->renderPartial('indexgrid', array('model'=>$model));
        ?>
        
        
        <?php
        if ($model->offer->status == Offers::STATUS_PASSIVE) {
        ?>
        <br /><br />
        <p class="text-right">
        <?= CHtml::link(Yii::t('app', 'Continue').' <i class="fa fa-angle-right"></i>', array('/offers/offerFaq/index', 'id' => $model->offer_id), array('class' => 'btn btn-muted')) ?>
        </p>
        <?php
        }
        ?>
    </div>