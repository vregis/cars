<?php
    /* @var $this PaymentsController */
    /* @var $model Payments */

    $this->pageTitle = Yii::t('app', 'My Outcome Payments').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Outcome Payments')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Total Balance') ?>: <?= $this->formatPrice($this->userModel->account) ?></h3>
        <p class="text-muted"><?= Yii::t('app', 'Available for withdraw') ?>: <?= $this->formatPrice($this->userModel->available_account) ?></p>
        
        <p class="text-right">
        <?= CHtml::link(Yii::t('app', 'Request Withdraw'), array('/orders/payments/requestWithdraw'), array('class' => 'btn btn-success btn-outline')) ?>
        </p>
        
        <?php
        $this->renderPartial('outcomegrid', array('model'=>$model));     
        ?>
    </div>