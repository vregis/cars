<?php
    $this->pageTitle = UserModule::t("Registration").' — '.Yii::app()->name;

    $this->breadcrumbs=array(
        UserModule::t("Registration"),
    );
?>

    <div class="container text-center">
        <br /><br />
        <h2><?= UserModule::t("Registration") ?></h2>
        <p class="text-muted"><?= Yii::t('app', 'Please, fill all fields.') ?></p>
        <br /><br />
        <div class="row">
            <div class="col-xs-12 col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-2">
                <?php if(Yii::app()->user->hasFlash('registration')): ?>

                    <p class="text-success text-center">
                        <big>
                            <?php echo Yii::app()->user->getFlash('registration'); ?><br />
                            <?php echo CHtml::errorSummary($model); ?>
                        </big>
                    </p>

                <?php endif; ?>
                <?php $form=$this->beginWidget('UActiveForm', array(
                    'id'=>'registration-form',
                    'enableAjaxValidation'=>true,
                    'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
                    'htmlOptions' => array('class'=>'text-left', 'role'=>'form'),
                )); ?>
                    
                    <div class="form-group">
                        <?php echo $form->label($model,'email',array('class'=>'control-label')); ?>
                        <?php echo $form->textField($model,'email',array('class'=>'form-control')); ?>
                        <small class="text-danger"><?php echo $form->error($model,'email'); ?></small>
                    </div>
                    
                    <div class="form-group">
                        <?php echo $form->label($model,'password',array('class'=>'control-label')); ?>
                        <?php echo $form->passwordField($model,'password',array('class'=>'form-control')); ?>
                        <small class="text-danger"><?php echo $form->error($model,'password'); ?></small>
                    </div>
                        
                    <div class="form-group">
                        <?php echo $form->label($model,'verifyPassword',array('class'=>'control-label')); ?>
                        <?php echo $form->passwordField($model,'verifyPassword',array('class'=>'form-control')); ?>
                        <small class="text-danger"><?php echo $form->error($model,'verifyPassword'); ?></small>
                    </div>
                    
                    <div class="form-group">
                        <?php
                            echo $form->checkBox($model,'legacy');
                            echo $form->label($model,'legacy');
                        ?>
                    </div>

                    <div class="form-group captcha-field">
                        <?php 
                            $reCaptcha = new ReCaptcha;
                            echo $reCaptcha->render(); 
                        ?>
                    </div>
                    <br />
                        
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success btn-solid"><?= Yii::t('app', 'Register') ?></button>
                    </div>

                <?php $this->endWidget(); ?>
            </div>
            <div class="col-xs-12 col-sm-5 col-md-4">
                
                <div class="form-group">
                    <label>&nbsp;</label><br />
                    <?php $this->widget('application.extensions.Facebook.loginWidget', array('label' => 'Sign in with Facebook')) ?>                    
                </div>
                
                <div class="form-group">
                    <?php $this->widget('application.extensions.Google.loginGWidget') ?>         
                </div>

            </div>
        </div>
    </div>