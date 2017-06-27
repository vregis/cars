<?php
    $this->pageTitle = Yii::t('app', '1. Personal information').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'Personal information')
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

                    <?php if ($model->first_complete == 3) { ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'email',array('class' => 'control-label')); ?>
                        <?php echo $form->textField($model,'email',array('class'=>'form-control')); ?>
                        <p class="text-right"><small><?php echo CHtml::link(Yii::t('app', 'Change password'), array('/user/profile/changepassword')); ?></small></p>
                    </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <?php
                                echo $form->checkBox($profile,'is_company');
                                echo $form->labelEx($profile,'is_company');
                                ?> <!-- <sup class="text-success">(+ 15%)</sup> -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group last_name_div">
                                <?php echo $form->labelEx($profile,'lastname',array('class' => 'control-label')); ?> <!-- <sup class="text-success">(+ 15%)</sup> -->
                                <?php echo $form->textField($profile,'lastname',array('class'=>'form-control')); ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div class="form-group first_name_div">
                                <?php echo $form->labelEx($profile,'firstname',array('class' => 'control-label')); ?> <!-- <sup class="text-success">(+ 15%)</sup> -->
                                <?php echo $form->textField($profile,'firstname',array('class'=>'form-control')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row not_for_company">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <?php echo $form->labelEx($profile,'birthday',array('class' => 'control-label')); ?><!--  <sup class="text-success">(+ 15%)</sup> -->
                                <?php $this->widget('application.components.widgets.beDatepickerBasic',array('model'=>$profile, 'attribute'=>'birthday')); ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <?php echo $form->labelEx($profile,'gender',array('class' => 'control-label')); ?>
                                <?php echo $form->dropDownList($profile,'gender',array(Yii::t('app', 'Male'), Yii::t('app', 'Female')),array('empty' => Yii::t('app', 'Select your gender...'), 'class'=>'form-control')); ?>
                            </div>
                        </div>
                    </div>
                    
                    <hr />

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <?php echo $form->labelEx($profile,'country_id',array('class' => 'control-label')); ?><!--  <sup class="text-success">(+ 15%)</sup> -->
                                <?php echo $form->dropDownList($profile,'country_id',ListCountries::model()->listData,array('class'=>'form-control', 'empty'=>Yii::t('app', 'Select country...'))); ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <?php echo $form->labelEx($profile,'city',array('class' => 'control-label')); ?><!--  <sup class="text-success">(+ 15%)</sup> -->
                                <?php echo $form->textField($profile,'city',array('class'=>'form-control')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <!-- <div class="form-group">
                                <?php echo $form->labelEx($profile,'languages',array('class' => 'control-label')); ?>
                                <?php 
                                    // $this->widget(
                                    //     'application.components.widgets.feSelect2',
                                    //     array(
                                    //         'model'=>$profile, 
                                    //         'attribute'=>'languages', 
                                    //         'data'=>ListLanguages::getListData(), 
                                    //         'url'=>'/listLanguages/getData',
                                    //         'htmlOptions'=>array('multiple'=>true),
                                     //  )
                                    //); 
                                ?>
                            </div> -->
                        </div>
                    </div>
                    
                    <hr />

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <?php echo $form->labelEx($profile,'notes',array('class' => 'control-label')); ?>
                                <?php echo $form->textArea($profile,'notes',array('class'=>'form-control', 'rows' => 7)); ?>
                            </div>
                        </div>
                    </div>

                    <br />

                    <h4><?= Yii::t('app', 'Синхронизируйте:') ?></h4>
                    <?php  
                    $this->widget('application.extensions.ulogin.components.UloginWidget', array(
    'params'=>$uparams
        //array(
        //'redirect'=>'http://'.$_SERVER['HTTP_HOST'].'/index.php?r=ulogin/synchro', //Адрес, на который ulogin будет редиректить //браузер клиента. Он должен соответствовать контроллеру ulogin и действию login
        //'view'=>'uloginWidgetSyn'
    
)); ?>
                    <?php 
                        // if (!stristr($this->userModel->social_identity, 'FB')) 
                        //     $this->widget('application.extensions.Facebook.loginWidget', array('redirectUrl' => '/user/profile/addAuthFB', 'label' => 'Connect Facebook'));
                        // else
                        //     echo CHtml::link('<i class="fa fa-check"></i>'.Yii::t('app', 'Facebook Connected'), '', array('class' => 'btn btn-facebook'));
                    ?> <!-- <span class="btn btn-success">+ 50%</span> -->
                    <br />
                    <?php 
                        // if (!stristr($this->userModel->social_identity, 'GP')) 
                        //     $this->widget('application.extensions.Google.loginGWidget', array('redirectUrl' => '/user/profile/addAuthGP', 'label' => 'Connect Google+'));
                        // else
                        //     echo CHtml::link('<i class="fa fa-check"></i>'.Yii::t('app', 'Google+ Connected'), '', array('class' => 'btn btn-google'));
                    ?><!-- <span class="btn btn-success">+ 50%</span> -->

                    <div class="form-group text-right">
                        <br />
                        <?php echo CHtml::link(Yii::t('app', 'Save & Continue').' <i class="fa fa-angle-right"></i>', '#', array('class' => 'btn btn-success btn-submit', 'data-target' => 'profile-form')); ?>     
                    </div>
                    
                </div>
                
                <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                   <?php //$this->renderPartial('_stats', array('model' => $model)); ?> 
                </div>
            </div>

       <?php $this->endWidget(); ?>
    </div>

<script>
    $(function(){
        $('input').on('ifChecked', function(event){
            isCompany()
        });
        $('input').on('ifUnchecked', function(event){
            isUser()
        });

        if($('#Profile_is_company').prop('checked')){
            isCompany();
        }else{
            isUser();
        }

    })

    function isCompany(){
        $('.last_name_div').find('label').html('Название компании <span class="required">*</span>');
        $('.first_name_div').find('label').html('Company ID <span class="required">*</span>');
        $('.not_for_company').hide();
    }
    
    function isUser() {
        $('.last_name_div').find('label').html('Фамилия');
        $('.first_name_div').find('label').html('Имя <span class="required">*</span>');
        $('.not_for_company').show();
    }
</script>
