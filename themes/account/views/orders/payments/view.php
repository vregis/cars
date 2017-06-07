<?php
    /* @var $this PaymentsController */
    /* @var $model Payments */

    $this->pageTitle = Yii::t('app', 'Payment #').$model->id.' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Payments') => array('/orders/payments/index'),
        Yii::t('app', 'Payment #').$model->id
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Payment #').$model->id ?></h3>
        <br />
        
        <table class="table table-striped">
            <tbody>
                <tr><td class="col-sm-3"><strong><?= Yii::t('app', 'Payment Type') ?></strong></td><td><?= $model->types[$model->type] ?></td></tr>
                <tr><td class="col-sm-3"><strong><?= Yii::t('app', 'Order #') ?></strong></td><td><?= '#'.$model->order_id ?> &nbsp;&nbsp;&nbsp;<small class="text-muted">(<?= $model->order->offer->title ?>)</small></td></tr>
                <tr><td class="col-sm-3"><strong><?= Yii::t('app', 'Payment Type') ?></strong></td><td><?= $model->paymentType->name ?></td></tr>
                <tr><td class="col-sm-3"><strong><?= Yii::t('app', 'Amount Paid') ?></strong></td><td><?= $model->amount ?></td></tr>
                <tr><td class="col-sm-3"><strong><?= Yii::t('app', 'Payer Name') ?></strong></td><td><?= $model->payer_name ?></td></tr>
                <tr><td class="col-sm-3"><strong><?= Yii::t('app', 'Transfer Number') ?></strong></td><td><?= $model->transfer_number ?></td></tr>
                <tr><td class="col-sm-3"><strong><?= Yii::t('app', 'Country') ?></strong></td><td><?= $model->country ?></td></tr>
                <tr><td class="col-sm-3"><strong><?= Yii::t('app', 'Date') ?></strong></td><td><?= Yii::app()->locale->dateFormatter->format(Yii::t('app', 'd MMMM yyyy, в H:mm'), $model->date_created) ?></td></tr>
                <tr><td class="col-sm-3"><strong><?= Yii::t('app', 'Approved') ?></strong></td><td><?php if ($model->is_approved) echo '<i class="fa fa-check"></i>'; else echo '&mdash;'; ?></td></tr>
            </tbody>
        </table>
    </div>