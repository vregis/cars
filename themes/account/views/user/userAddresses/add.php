<?php
/* @var $this OfferAddressesController */
/* @var $model OfferAddresses */

    $this->pageTitle = Yii::t('app', 'New Address').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'My Addresses') => array('/user/userAddresses/index'),
        Yii::t('app', 'New Address')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'New Address') ?></h3>
        <br />
        
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>