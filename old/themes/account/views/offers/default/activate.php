<?php
/* @var $this UserDocumentsController */
/* @var $model UserDocuments */

    $this->pageTitle = Yii::t('app', 'Offer #').$model->id.' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'Offer #').$model->id
    );

    $owner = $model->owner->profile;
    
    if (!empty($model->primaryPhoto))
        $img_src = Yii::app()->request->hostInfo.'/resources/offers/400_'.$model->primaryPhoto->filename;
    else
        $img_src = Yii::app()->theme->baseUrl.'/img/blank_offer.png';

    $this->renderPartial('_tabs', array('model' => $model));    
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Offer #').$model->id ?></h3>
        
        <p class="lead text-success"><?= Yii::t('app', 'Спасибо! Ваше предложение опубликовано, и будет проверено в течение 12 часов.') ?></p>
                
        
        <?= CHtml::link(Yii::t('app', 'Вернуться к предложению').' <i class="fa fa-angle-right"></i>', array('/offers/default/edit', 'id' => $model->id), array('class' => 'btn btn-success')) ?>
    </div>