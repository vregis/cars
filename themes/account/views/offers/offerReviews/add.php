<?php
/* @var $this OfferReviewsController */
/* @var $model OfferReviews */

    $this->breadcrumbs=array(
        Yii::t('app', 'My Orders') => array('/orders/default/index'),
        Yii::t('app', 'Order #').$user_model->order_id => array('/orders/default/edit', 'id' => $user_model->order_id),
        Yii::t('app', 'Review')
    );

    $this->pageTitle = Yii::t('app', 'Review').' | '.Yii::app()->name;
?>


<div class="container">
    
    <?php $form=$this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'')
    )); ?>
    
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <h3><?= Yii::t('app', 'Offer Review') ?></h3>
            <br />
            <?php echo $this->renderPartial('_offerform', array('form'=>$form, 'model'=>$offer_model, 'photomodel'=>$offer_photomodel)); ?>
        </div>
        <div class="col-xs-12 col-sm-6">
            <h3><?= Yii::t('app', 'Owner Review') ?></h3>
            <br />
            <?php echo $this->renderPartial('_userform', array('form'=>$form, 'model'=>$user_model)); ?>
        </div>
    </div>

    <br /><br />
    <div class="form-group text-center">
        <button class="btn btn-success" type="submit"><?= Yii::t('app', 'Submit Reviews') ?></button>
    </div>

    <?php $this->endWidget(); ?>
</div>