<?php
    /* @var $this PaymentsController */
    /* @var $model Payments */

    $this->pageTitle = Yii::t('app', 'My Income Payments').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Income Payments')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Total Balance') ?>: <?= $this->formatPrice($this->userModel->account) ?></h3>
        
        <?php
        $this->renderPartial('incomegrid', array('model'=>$model));     
        ?>
    </div>