<?php
/* @var $this UserDocumentsController */
/* @var $model UserDocuments */

    $this->pageTitle = Yii::t('app', 'New Document').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Profile') => array('/user/profile/edit'),
        Yii::t('app', 'My Documents') => array('/user/userDocuments/index'),
        Yii::t('app', 'New Document')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'New Document') ?></h3>
        
        <div class="row">
            <div class="col-xs-12 col-sm-6">
            <?php
                $this->renderPartial('_form', array('model'=>$model));    
            ?>
            </div>
        </div>
    </div>