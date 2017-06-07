<?php 
    $this->pageTitle = UserModule::t("Restore access").' — '.Yii::app()->name;

    $this->breadcrumbs=array(
        UserModule::t("Restore access"),
    );
?>

    <div class="container text-center">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <h2><?= UserModule::t("Restore access") ?></h2>
                <br /><br />
                <?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>

                    <p class="text-danger text-center">
                        <big>
                            <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?><br />
                            <?php echo CHtml::errorSummary($form); ?>
                        </big>
                    </p>

                <?php else: ?>

                <?php echo CHtml::beginForm('', 'POST', array('class'=>'m-t', 'role'=>'form')); ?>  
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-offset-1">                      
                            <?php echo CHtml::activeTextField($form,'login_or_email', array('class' => 'form-control', 'placeholder' => 'E-mail')) ?>
                        </div>
                        <div class="col-xs-12 col-md-4 text-left"> 
                            <button type="submit" class="btn btn-success btn-solid"><?php echo UserModule::t("Restore"); ?></button>
                        </div>
                    </div>
                <?php echo CHtml::endForm(); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>