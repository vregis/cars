<?php
    /* @var $this OfferAddressesController */
    /* @var $model OfferAddresses */

    $this->pageTitle = Yii::t('app', 'My Messages').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Messages')
    );
?>

<div class="im-empty"><i class="fa fa-comments-o fa-5x"></i></div>

<p class="text-muted lead text-center"><?= Yii::t('app', 'Please, select dialog from your contacts list.') ?></p>