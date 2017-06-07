<?php
    $this->pageTitle = Yii::t('app', 'Profile Edit').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'Profile Edit')
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
        <h3><?= Yii::t('app', 'Profile Edit') ?></h3>
        <br />
        
        <?php $form=$this->beginWidget('UActiveForm', array(
            'id'=>'profile-form',
            'enableAjaxValidation'=>true,
            'htmlOptions' => array('enctype'=>'multipart/form-data'),
        )); ?>
        
        <div class="row">
            <div class="col-xs-12 col-sm-4">                
                <?= CHtml::image($profile->rawPhoto, $profile->name, array('class' => 'img-responsive')); ?>
                    
                <div class="photo-delete-panel">
                    <div>
                    <?php 
                    if (!empty($profile->photo))
                        echo CHtml::link(Yii::t('app', 'Remove').'<i class="fa fa-times"></i>', array('deletePhoto', 't'=>0), array('confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'class'=>'pull-right'));
                    
                    echo CHtml::activeFileField($profile, 'photo', array('class' => 'hidden profile-image-file', 'accept' => 'image/*'));
                    echo CHtml::link('<i class="fa fa-download"></i>'.Yii::t('app', 'Upload photo...'), '#', array('confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'class'=>'profile-image'));
                    ?>
                    </div>
                </div>
                        
                <div class="row" style="margin-top: 30px;">
                    <div class="col-xs-6">                
                        <?= CHtml::image($profile->getSquarePhoto('photo2'), $profile->name, array('class' => 'img-responsive')); ?>

                        <div class="photo-delete-panel">
                            <div>
                            <?php 
                            if (!empty($profile->photo2))
                                echo CHtml::link('<i class="fa fa-times"></i>', array('deletePhoto', 't'=>1), array('confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'class'=>'pull-right'));

                            echo CHtml::activeFileField($profile, 'photo2', array('class' => 'hidden profile-image-file', 'accept' => 'image/*'));
                            echo CHtml::link('<i class="fa fa-download"></i>', '#', array('confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'class'=>'profile-image'));
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">                
                        <?= CHtml::image($profile->getSquarePhoto('photo3'), $profile->name, array('class' => 'img-responsive')); ?>

                        <div class="photo-delete-panel">
                            <div>
                            <?php 
                            if (!empty($profile->photo3))
                                echo CHtml::link('<i class="fa fa-times"></i>', array('deletePhoto', 't'=>2), array('confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'class'=>'pull-right'));

                            echo CHtml::activeFileField($profile, 'photo3', array('class' => 'hidden profile-image-file', 'accept' => 'image/*'));
                            echo CHtml::link('<i class="fa fa-download"></i>', '#', array('confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'class'=>'profile-image'));
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-8">

                <?php echo $form->errorSummary(array($model,$profile)); ?>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'email',array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model,'email',array('class'=>'form-control')); ?>
                            <p class="text-right"><small><?php echo CHtml::link(Yii::t('app', 'Change password'), array('/user/profile/changepassword')); ?></small></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($profile,'public_phone',array('class' => 'control-label')); ?>
                            <?php echo $form->textField($profile,'public_phone',array('class'=>'form-control phone-code')); ?>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($profile,'alter_phone',array('class' => 'control-label')); ?>
                            <?php echo $form->textField($profile,'alter_phone',array('class'=>'form-control phone-code')); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($profile,'lastname',array('class' => 'control-label')); ?>
                            <?php echo $form->textField($profile,'lastname',array('class'=>'form-control')); ?>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($profile,'firstname',array('class' => 'control-label')); ?>
                            <?php echo $form->textField($profile,'firstname',array('class'=>'form-control')); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($profile,'country_id',array('class' => 'control-label')); ?>
                            <?php echo $form->dropDownList($profile,'country_id',ListCountries::model()->listData,array('class'=>'form-control', 'empty'=>Yii::t('app', 'Select country...'))); ?>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($profile,'city',array('class' => 'control-label')); ?>
                            <?php echo $form->textField($profile,'city',array('class'=>'form-control')); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($profile,'gender',array('class' => 'control-label')); ?>
                            <?php echo $form->dropDownList($profile,'gender',array(Yii::t('app', 'Male'), Yii::t('app', 'Female')),array('empty' => Yii::t('app', 'Select your gender...'), 'class'=>'form-control')); ?>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($profile,'birthday',array('class' => 'control-label')); ?>
                            <?php $this->widget('application.components.widgets.feDatepicker',array('model'=>$profile, 'attribute'=>'birthday', 'time' => false)); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <?php echo $form->labelEx($profile,'languages',array('class' => 'control-label')); ?>
                            <?php 
                                $this->widget(
                                    'application.components.widgets.feSelect2',
                                    array(
                                        'model'=>$profile, 
                                        'attribute'=>'languages', 
                                        'data'=>ListLanguages::getListData(), 
                                        'url'=>'/listLanguages/getData',
                                        'htmlOptions'=>array('multiple'=>true),
                                    )
                                ); 
                            ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <?php echo $form->labelEx($profile,'notes',array('class' => 'control-label')); ?>
                            <?php echo $form->textArea($profile,'notes',array('class'=>'form-control', 'rows' => 7)); ?>
                        </div>
                    </div>
                </div>
        
                <br />
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <?php
                                echo $form->checkBox($profile,'is_company');
                                echo $form->labelEx($profile,'is_company');
                            ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <br />
                    <?php echo CHtml::link(Yii::t('app', 'Save changes').' <i class="fa fa-angle-right"></i>', '#', array('class' => 'btn btn-success btn-submit', 'data-target' => 'profile-form')); ?>

                    <?php if (Yii::app()->user->hasFlash('profileMessage')): ?>
                    <p class="text-success"><br /><small><?php echo Yii::app()->user->getFlash('profileMessage'); ?></small></p>
                    <?php endif; ?>        
                </div>

            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>

    <h4><?= Yii::t('app', 'Connected Accounts') ?></h4>
    <br /><br />
    <?php 
        if (!stristr($this->userModel->social_identity, 'FB')) 
            $this->widget('application.extensions.Facebook.loginWidget', array('redirectUrl' => '/user/profile/addAuthFB'));
        else
            echo CHtml::link('<i class="fa fa-facebook"></i>'.Yii::t('app', 'Facebook Connected'), '', array('class' => 'btn btn-facebook'));
    ?>
    <br />
    <?php 
        if (!stristr($this->userModel->social_identity, 'GP')) 
            $this->widget('application.extensions.Google.loginGWidget', array('redirectUrl' => '/user/profile/addAuthGP'));
        else
            echo CHtml::link('<i class="fa fa-google-plus"></i>'.Yii::t('app', 'Google+ Connected'), '', array('class' => 'btn btn-google'));
    ?>