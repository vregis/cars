<?php
    $this->pageTitle = Yii::t('app', '3. My Phones').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Phones')
    );
    
    if (!empty($profile->province_id)) {
        $profile->country = $profile->province->country_id;
        
        $raw_data = ListProvinces::model()->findAll(array(
            'condition' => '`country_id` = :country_id',
            'params' => array(':country_id' => $profile->country),
        ));
        $provinces_list = CHtml::listData($raw_data, 'id', function($data) {return $data->fullName;});
    } else 
        $provinces_list = array();
?>


    <div class="account-content">
        <h3><?= Yii::t('app', 'Profile Information') ?></h3>
        <br />

        <?php $this->renderPartial('_tabs', array('model' => $model)) ?>
        <br />
        
        <?php $form=$this->beginWidget('UActiveForm', array(
            'id'=>'profile-form',
            'enableAjaxValidation'=>true,
            'htmlOptions' => array('enctype'=>'multipart/form-data'),
        )); ?>

            <?php if (Yii::app()->user->hasFlash('profileMessage')): ?>
            <p class="text-success"><br /><small><?php echo Yii::app()->user->getFlash('profileMessage'); ?></small></p>
            <?php endif; ?>    
        
            <div class="row">
                <div class="col-xs-12 col-sm-7">

                    <?php echo $form->errorSummary(array($model,$profile)); ?>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <?php echo $form->labelEx($profile,'public_phone',array('class' => 'control-label')); ?> <sup class="text-success">(+ 50%)</sup><br />
                                <?php echo $form->textField($profile,'public_phone',array('class'=>'form-control phone-code')); ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <?php echo $form->labelEx($profile,'alter_phone',array('class' => 'control-label')); ?><br />
                                <?php echo $form->textField($profile,'alter_phone',array('class'=>'form-control phone-code')); ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6">
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <br />
                        <?php echo CHtml::link(Yii::t('app', 'Save & Continue').' <i class="fa fa-angle-right"></i>', '#', array('class' => 'btn btn-success btn-submit', 'data-target' => 'profile-form')); ?>    
                    </div>
                    
                </div>
                
                <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                    <?php $this->renderPartial('_stats', array('model' => $model)); ?>
                </div>
            </div>

        <?php $this->endWidget(); ?>
    </div>