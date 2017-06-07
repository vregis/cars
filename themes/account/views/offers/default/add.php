<?php
/* @var $this UserDocumentsController */
/* @var $model UserDocuments */

    $this->pageTitle = Yii::t('app', 'Add new offer').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'Add new offer')
    );

    $owner = $model->owner->profile;
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Add new offer') ?></h3>
        
        <?php
            $this->renderPartial('_form', array('model' => $model, 'a_addresses' => array()));    
        ?>
    </div>