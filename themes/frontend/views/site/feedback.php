<?php    
    $this->pageTitle = Yii::t('app', 'Feedback').' | '.Yii::app()->name;
    
    $this->breadcrumbs = array(
        Yii::t('app', 'Feedback')
    );
?>

        <!-- Feedback -->   
        <div class="container">
            <div class="row info-block">
                <div class="col-xs-12 col-md-4 col-md-offset-3">
                    <h2 class="text-center text-success"><?= Yii::t('app', 'Feedback Form') ?></h2>
                    <br />
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6 col-md-offset-1">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'clientOptions' => array(
                            'errorCssClass' => 'has-error',
                        ),
                        'id'=>'feedback-form',
                        'enableClientValidation' => true,
                        'htmlOptions' => array(
                            'class'=>'form-horizontal',
                        )
                    )); ?>  

                        <div class="form-group">
                            <label for="FormFeedback[name]" class="col-xs-12 col-sm-4 control-label"><?= Yii::t('app', 'Your Name') ?> <span class="required">*</span></label>
                            <div class="col-xs-12 col-sm-8">
                                <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
                                <small class="text-danger"><?php echo $form->error($model,'name'); ?></small>
                            </div>
                        </div>  

                        <div class="form-group">
                            <label for="FormFeedback[email]" class="col-xs-12 col-sm-4 control-label"><?= Yii::t('app', 'Your E-mail') ?> <span class="required">*</span></label>
                            <div class="col-xs-12 col-sm-8">
                                <?php echo $form->textField($model,'email',array('class'=>'form-control')); ?>
                                <small class="text-danger"><?php echo $form->error($model,'email'); ?></small>
                            </div>
                        </div>  

                        <div class="form-group">
                            <label for="FormFeedback[reason]" class="col-xs-12 col-sm-4 control-label"><?= Yii::t('app', 'Reason') ?> <span class="required">*</span></label>
                            <div class="col-xs-12 col-sm-8">
                                <?php echo $form->dropDownList($model,'reason',$model->reasons,array('class'=>'form-control selectpicker')); ?>
                                <small class="text-danger"><?php echo $form->error($model,'reason'); ?></small>
                            </div>
                        </div>  
                        
                        <div class="form-group">
                            <label for="FormFeedback[notes]" class="col-xs-12 col-sm-4 control-label"><?= Yii::t('app', 'Your Message') ?> <span class="required">*</span></label>
                            <div class="col-xs-12 col-sm-8">
                                <?php echo $form->textArea($model,'notes',array('class'=>'form-control', 'rows'=>7)); ?>
                                <small class="text-danger"><?php echo $form->error($model,'notes'); ?></small>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-8 col-sm-offset-4">
                                <?php
                                if (!isset($result) || (!$result)) 
                                    echo '<a href="#" class="btn btn-success btn-submit" data-target="feedback-form">'.Yii::t('app', 'Submit Feedback').' <i class="fa fa-angle-right"></i></a>';
                                else
                                    echo '<p class="text-center"><small class="text-success">'.Yii::t('app', 'Your message sent. Thank you!').'</small></p>';
                                ?> 
                            </div>
                        </div>

                    <?php $this->endWidget(); ?>
                </div>
                <div class="col-xs-12 col-md-5">
                    <p class="small-lead"><?= Yii::t('app', 'Feedback info part 1: The movement of the rotor requires more attention to the analysis of errors that gives the pitch. However, the study of the problem in a more rigorous formulation shows that the integral of variable integrates the moment.') ?></p>
                    <p class="small-lead"><?= Yii::t('app', 'Feedback info part 2: The angular velocity of the gyroscopic effect on the components of the moment more than a resonance angular momentum of its own in accordance with the system of equations.') ?></p>
                </div>  
            </div>  
        </div>