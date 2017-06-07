<?php
/* @var $this UserDocumentsController */
/* @var $model UserDocuments */

    $this->pageTitle = Yii::t('app', 'Edit Offer #').$model->id.' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'Edit Offer #').$model->id
    );

    $owner = $model->owner->profile;
    
    if (!empty($model->primaryPhoto))
        $img_src = Yii::app()->request->hostInfo.'/resources/offers/400_'.$model->primaryPhoto->filename;
    else
        $img_src = Yii::app()->theme->baseUrl.'/img/blank_offer.png';

    $this->renderPartial('_tabs', array('model' => $model));    
?>

    <div class="account-content">
        <h3><?= $model->title ?></h3>
        
        <?php
            $this->renderPartial('_form', array('model' => $model, 'a_addresses' => $a_addresses, 'address_model' => $address_model));    
        ?>
    </div>