<?php
    /* @var $this PaymentsController */
    /* @var $model Payments */

    $this->pageTitle = Yii::t('app', 'My Payments').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Payments')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Balance') ?>: <?= $this->formatPrice($this->userModel->account) ?></h3>
        
        <?php
        $this->renderPartial('indexgrid', array('model'=>$model));     
        ?>
    </div>