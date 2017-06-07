<?php
/* @var $this OfferDocumentsController */
/* @var $model OfferDocuments */

    $this->pageTitle = Yii::t('app', 'Edit Period').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'Offer #').$model->offer_id => array('/offers/default/edit', 'id' => $model->offer_id),
        Yii::t('app', 'Offer Blocking') => array('/offers/offerDocuments/index', 'id' => $model->offer_id),
        Yii::t('app', 'Edit Period')
    );

    $this->renderPartial('/default/_tabs', array('model' => $model->offer)); 
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Edit Period') ?></h3>
        
        <?php
            $this->renderPartial('_form', array('model'=>$model));
        ?>
    </div>