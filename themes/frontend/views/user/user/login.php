<?php
    $this->pageTitle = UserModule::t("Login").' — '.Yii::app()->name;

    $this->breadcrumbs=array(
        UserModule::t("Login"),
    );
?>

    <div class="container text-center">
        <br /><br />
        <h2><?= Yii::t('app', 'Sign in') ?></h2>
        <br /><br />
        <div class="row">
            <div class="col-xs-12 col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-2">
                
                <?php if (!empty($model->errors)): ?>
                    <p class="text-danger text-left">
                        <?php
                        foreach ($model->errors as $errors) {
                            foreach ($errors as $error) {
                                echo $error.'<br />';
                            }
                        }
                        ?>
                    </p>

                    <br />
                <?php endif; ?>
                
                <?php echo CHtml::beginForm('', 'POST', array('class'=>'text-right', 'role'=>'form')); ?>  
                <div class="form-group">
                    <?php echo CHtml::activeTextField($model,'username',array('class'=>'form-control', 'placeholder' => 'E-mail')); ?>
                    <small class="text-muted"><?= Yii::t('app', 'Don\'t have an account?') ?> <?php echo CHtml::link(Yii::t('app', 'Register'), array('/user/registration/registration')); ?></small>
                </div>
                
                <div class="form-group">
                    <?php echo CHtml::activePasswordField($model,'password',array('class'=>'form-control', 'placeholder' => Yii::t('app', 'Password'))); ?>
                    <small><?php echo CHtml::link(Yii::t('app', 'Forgot your password?'), array('/user/recovery/recovery')); ?></small>
                </div>
                
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-solid"><?= Yii::t('app', 'Sign in') ?></button>
                </div>
                    
                <?php echo CHtml::endForm(); ?>
            </div>
            <div class="col-xs-12 col-sm-5 col-md-4">
                
                <div class="form-group">
<!--UNDER CONSTRUCTION-->
                 <?php  $this->widget('application.extensions.ulogin.components.UloginWidget', array(
    'params'=>array(
        'redirect'=>'http://'.$_SERVER['HTTP_HOST'].'/index.php?r=ulogin/login' //Адрес, на который ulogin будет редиректить браузер клиента. Он должен соответствовать контроллеру ulogin и действию login
    )
)); ?><!-- 
                   <?php $this->widget('application.extensions.Facebook.loginWidget', array('label' => 'Sign in with Facebook')) ?>                
                </div>
                
                <div class="form-group">
                    <?php $this->widget('application.extensions.Google.loginGWidget') ?>    -->      
                </div>

            </div>
        </div>
    </div>
    <br /><br /><br />