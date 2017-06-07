<?php 
    $this->pageTitle = UserModule::t("Change Password").' — '.Yii::app()->name;

    $this->breadcrumbs=array(
        UserModule::t("Change Password"),
    );
?>

    <div class="container text-center">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <h2><?= UserModule::t("Change Password") ?></h2>
                <br /><br />
                <?php echo CHtml::errorSummary($form); ?>

                <?php echo CHtml::beginForm(); ?>
                    <div class="row text-left">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                            <div class="form-group">
                                <?php echo CHtml::activeLabelEx($form,'password',array('class'=>'control-label')); ?>
                                <?php echo CHtml::activePasswordField($form,'password', array('class' => 'form-control')); ?>
                            </div>
                    
                            <div class="form-group">
                                <?php echo CHtml::activeLabelEx($form,'verifyPassword',array('class'=>'control-label')); ?>
                                <?php echo CHtml::activePasswordField($form,'verifyPassword', array('class' => 'form-control')); ?>
                            </div>                 
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-solid"><?php echo UserModule::t("Save"); ?></button>
                            </div>                    
                        </div>
                    </div>
                <?php echo CHtml::endForm(); ?>
            </div>
        </div>
    </div>