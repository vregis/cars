<?php
/* @var $this OfferOptionsController */
/* @var $model OfferOptions */

    $this->pageTitle = Yii::t('app', 'Edit Lot').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'Offer #').$model->offer_id => array('/offers/default/edit', 'id' => $model->offer_id),
        Yii::t('app', 'Offer Options') => array('/offers/offerOptions/index', 'id' => $model->offer_id),
        Yii::t('app', 'Edit Lot')
    );

    $this->renderPartial('/default/_tabs', array('model' => $model->offer));  
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Edit Lot') ?></h3>
        
        <?php

            $this->renderPartial('_form', array('model'=>$model));
        ?>
        <h3><?= Yii::t('app', 'Additions') ?></h3>
        <?php
            unset($model->order);//bug in sql workaround
            $model->main_option=0;
            
            //var_dump($model);
            $_id=$model->offer_id;
            $_main_option_id=$model->main_option_id;
            $model=new OfferOptions;
            $model->offer_id = $_id;
            $model->main_option_id = $_main_option_id;
            $model->main_option = 0;
            unset($model->order);//bug in sql workaround
            //echo "mo:".$model->main_option_id;
            //echo "  of:".$model->offer_id;
            $this->renderPartial('indexgrid', array('model'=>$model));
            //$model->main_option=1;
        ?>
    </div>