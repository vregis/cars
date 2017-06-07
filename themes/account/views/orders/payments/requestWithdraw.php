<?php
    /* @var $this PaymentsController */
    /* @var $model Payments */

    $this->pageTitle = Yii::t('app', 'Request Withdraw').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Payments') => array('/orders/payments/index'),
        Yii::t('app', 'Request Withdraw')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Request Withdraw') ?></h3>
        <p class="text-muted"><?= Yii::t('app', 'Available for withdraw') ?>: <?= $this->formatPrice($this->userModel->available_account) ?></p>
                
        <?php 
        if (!isset($_GET['sent'])) {
        ?>
        <br /><p>Please, enter amount, that you want to withdraw.</p>
        
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'payments-form',
            'enableAjaxValidation'=>false,
            'htmlOptions' => array('class'=>'')
        )); ?>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                            <?= $form->textField($model,'amount',array('class'=>'form-control', 'placeholder' => $this->userModel->available_account)) ?>
                        </div>
                        <span class="help-block m-b-none"><?php echo $form->error($model,'amount'); ?></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-success" type="submit"><?= Yii::t('app', 'Submit') ?></button>
            </div>

        <?php $this->endWidget(); ?>
        
        <?php
        } else {
        ?>
        <p class="text-success lead">Thank you! Your request will be processed soon.</p>
        <?php
        }
        ?>

    </div>