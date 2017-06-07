<?php
/* @var $this OfferAddressesController */
/* @var $model OfferAddresses */

    $this->pageTitle = Yii::t('app', 'Edit Address').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'My Addresses') => array('/user/userAddresses/index'),
        Yii::t('app', 'Edit Address')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Edit Address') ?></h3>
        <br />
        
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>