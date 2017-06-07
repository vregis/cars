<?php    
    $this->pageTitle = Yii::t('app', 'Unsubscribe').' | '.Yii::app()->name;
    
    $this->breadcrumbs = array(
        Yii::t('app', 'Unsubscribe')
    );
?>

        <!-- Feedback -->   
        <div class="container">
            <div class="row info-block">
                <div class="col-xs-12 col-md-4 col-md-offset-3">
                    <h2 class="text-center text-success"><?= Yii::t('app', 'Unsubscribe') ?></h2>
                    <br />
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-md-8 col-md-offset-2">                    
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'clientOptions' => array(
                            'errorCssClass' => 'has-error',
                        ),
                        'method' => 'GET',
                        'enableClientValidation' => true,
                        'htmlOptions' => array(
                            'class'=>'form-horizontal',
                        )
                    )); ?>  

                        <div class="form-group">
                            <label for="email" class="col-xs-12 col-sm-3 control-label"><?= Yii::t('app', 'Your E-mail') ?> <span class="required">*</span></label>
                            <div class="col-xs-12 col-sm-9">
                                <?php echo CHtml::textField('email',((isset($_GET['email']))?($_GET['email']):('')),array('class'=>'form-control')); ?>
                            </div>
                        </div>  

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-9 col-sm-offset-3">
                                <?php
                                if (!isset($result) || (!$result)) 
                                    echo '<button class="btn btn-sm btn-success" type="submit">'.Yii::t('app', 'Unsubscribe').'</button>';
                                else
                                    echo '<p class="text-center"><small class="text-success">'.Yii::t('app', 'Your e-mail was unsubscribed. Thank you!').'</small></p>';
                                ?>            
                            </div>
                        </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>                
        </div>
