<?php
    /* @var $this OfferAddressesController */
    /* @var $model OfferAddresses */

    $this->pageTitle = Yii::t('app', 'My Messages').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Messages')
    );
?>    
    <div class="message-dialog">
        <iframe src="<?= Yii::app()->createAbsoluteUrl('/user/privateMessages/dialogWindow', array('id' => $id)) ?>" width="100%" height="800" frameborder="0" allowfullscreen class="dialog-frame">Sorry, dialog can't be shown.</iframe>
    </div>