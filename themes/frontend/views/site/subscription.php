<?php    
    $this->pageTitle = Yii::t('app', 'Subscription').' | '.Yii::app()->name;
    
    $this->breadcrumbs = array(
        Yii::t('app', 'Subscription')
    );
?>

        <!-- Feedback -->   
        <div class="container">
            <div class="row info-block">
                <div class="col-xs-12 col-md-4 col-md-offset-3">
                    <h2 class="text-center text-success"><?= Yii::t('app', 'Subscription') ?></h2>
                    <br />
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-md-8">                    
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'clientOptions' => array(
                            'errorCssClass' => 'has-error',
                        ),
                        'method' => 'POST',
                        'enableClientValidation' => true,
                        'htmlOptions' => array(
                            'class'=>'form-horizontal',
                        )
                    )); ?>  

                        <div class="form-group">
                            <label for="Subscribers[name]" class="col-xs-12 col-sm-3 control-label"><?= Yii::t('app', 'Your Name') ?> <span class="required">*</span></label>
                            <div class="col-xs-12 col-sm-9">
                                <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
                                <small class="text-danger"><?php echo $form->error($model,'name'); ?></small>
                            </div>
                        </div>  

                        <div class="form-group">
                            <label for="Subscribers[email]" class="col-xs-12 col-sm-3 control-label"><?= Yii::t('app', 'Your E-mail') ?> <span class="required">*</span></label>
                            <div class="col-xs-12 col-sm-9">
                                <?php echo $form->textField($model,'email',array('class'=>'form-control')); ?>
                                <small class="text-danger"><?php echo $form->error($model,'email'); ?></small>
                            </div>
                        </div>  

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-9 col-sm-offset-3 checkbox">
                                <label>
                                    <?php echo CHtml::checkBox('accepted', false, array('id' => 'accepted')); ?> <?= Yii::t('app', 'I accept licence agreement.') ?>
                                </label>
                                <small class="text-danger"><?php echo $form->error($model,'accepted'); ?></small>
                            </div>
                        </div>   

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-9 col-sm-offset-3">
                                <?php
                                if (!isset($result) || (!$result)) 
                                    echo '<button class="btn btn-sm btn-success" type="submit">'.Yii::t('app', 'Subscribe').'</button>';
                                else
                                    echo '<p class="text-center"><small class="text-success">'.Yii::t('app', 'Your e-mail was subscribed. Thank you!').'</small></p>';
                                ?>            
                            </div>
                        </div>

                    <?php $this->endWidget(); ?>
                </div>
                <div class="col-xs-12 col-md-4">
                    <p class="small-lead"><?= Yii::t('app', 'Want to get news and actions first?') ?></p>
                    <p class="small-lead"><?= Yii::t('app', 'Just fill in the form, so we know how to contact you.') ?></p>
                </div>  
            </div>                
        </div>
