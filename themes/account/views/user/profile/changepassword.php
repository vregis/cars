<?php 
    $this->pageTitle = Yii::t('app', 'Password change').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'Profile Edit') => array('/user/profile/edit'),
        Yii::t('app', 'Password change')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Password change') ?></h3>
        <br />

        <?php $form=$this->beginWidget('UActiveForm', array(
            'id'=>'profile-form',
            'enableAjaxValidation'=>true,
            'htmlOptions' => array('enctype'=>'multipart/form-data'),
        )); ?>

            <?php echo $form->errorSummary($model); ?>

            <?php
            if (Yii::app()->controller->id == 'firstPass') {
            ?>
            <p><?= Yii::t('app', 'Actual password') ?></p>
            
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <?php echo $form->passwordField($model,'oldPassword', array('class' => 'form-control', 'placeholder' => Yii::t('app', 'Enter your actual password'))); ?>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>

            <p><?= Yii::t('app', 'New password') ?></p>
            
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <?php echo $form->passwordField($model,'password', array('class' => 'form-control', 'placeholder' => Yii::t('app', 'Password'))); ?>
                    </div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <?php echo $form->passwordField($model,'verifyPassword', array('class' => 'form-control', 'placeholder' => Yii::t('app', 'Password again'))); ?>
                    </div>
                </div>
            </div>
        
            <div class="form-group">
                <br />
                <?php echo CHtml::link(Yii::t('app', 'Save changes').' <i class="fa fa-angle-right"></i>', '#', array('class' => 'btn btn-success btn-submit', 'data-target' => 'profile-form')); ?>
            </div>
        
        <?php $this->endWidget(); ?>
    </div>