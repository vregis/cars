<?php
    $this->pageTitle = UserModule::t("Registration").' — '.Yii::app()->name;
    
    $this->breadcrumbs = array(
        UserModule::t("Registration"),
    );
?>
<div class="container">
	<!-- Main Heading Starts -->
    <h2 class="main-heading text-center">
        <?php echo UserModule::t("Registration"); ?>
    </h2>

    <?php if(Yii::app()->user->hasFlash('registration')): ?>
    <div class="success col-sm-6 col-sm-offset-3">
    <?php echo Yii::app()->user->getFlash('registration'); ?>
    </div>
    <?php else: ?>
    
	<!-- Main Heading Ends -->
	<!-- Registration Section Starts -->
		<section class="registration-area">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
				<!-- Registration Block Starts -->
					<div class="panel panel-smart">
						<div class="panel-heading">
							<h3>Информация для входа</h3>
						</div>
						<div class="panel-body">
						<!-- Registration Form Starts -->
                            <?php $form=$this->beginWidget('UActiveForm', array(
                                'id'=>'registration-form',
                                'enableAjaxValidation'=>true,
                                'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
                                'htmlOptions' => array('class'=>'form-horizontal', 'role'=>'form'),
                            )); ?>
                        
                            <?php echo $form->errorSummary(array($model,$profile)); ?>
                        
								<div class="form-group">
                                    <?php echo $form->label($model,'username',array('class'=>'col-sm-3 control-label')); ?>
									<div class="col-sm-9">
                                        <?php echo $form->textField($model,'username',array('class'=>'form-control')); ?>
                                        <?php echo $form->error($model,'username'); ?>
									</div>
								</div>

								<div class="form-group">
                                    <?php echo $form->label($model,'email',array('class'=>'col-sm-3 control-label')); ?>
									<div class="col-sm-9">
                                        <?php echo $form->textField($model,'email',array('class'=>'form-control')); ?>
                                        <?php echo $form->error($model,'email'); ?>
									</div>
								</div>
                                                        
								<h3 class="panel-heading inner">
									Пароль
								</h3>

								<div class="form-group">
                                    <?php echo $form->label($model,'password',array('class'=>'col-sm-3 control-label')); ?>
									<div class="col-sm-9">
                                        <?php echo $form->passwordField($model,'password',array('class'=>'form-control')); ?>
                                        <?php echo $form->error($model,'password'); ?>
									</div>
								</div>

								<div class="form-group">
                                    <?php echo $form->label($model,'verifyPassword',array('class'=>'col-sm-3 control-label')); ?>
									<div class="col-sm-9">
                                        <?php echo $form->passwordField($model,'verifyPassword',array('class'=>'form-control')); ?>
                                        <?php echo $form->error($model,'verifyPassword'); ?>
									</div>
								</div>

                                <?php if (UserModule::doCaptcha('registration')): ?>
                                <div class="row odd">
                                    <?php echo $form->labelEx($model,'verifyCode',array('class'=>'col-sm-3 control-label')); ?>

                                    <div class="col-sm-9">
                                        <?php $this->widget('CCaptcha'); ?><br />
                                        <?php echo $form->textField($model,'verifyCode',array('class'=>'form-control')); ?>
                                        <?php echo $form->error($model,'verifyCode'); ?>

                                        <span class="help-block m-b-none"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?></span>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php 
                                    $profileFields=$profile->getFields();
                                    if ($profileFields) {
                                        echo '<h3 class="panel-heading inner">Дополнительные данные</h3>';
                                        $i = 0;
                                        foreach($profileFields as $field) {
                                            $i++;
                                        ?>
                                    <div class="form-group">
                                        <?php echo $form->labelEx($profile,$field->varname,array('class'=>'col-sm-3 control-label')); ?>
                                        <div class="col-sm-9">
                                            <?php 
                                            if ($field->widgetEdit($profile)) {
                                                echo $field->widgetEdit($profile);
                                            } elseif ($field->range) {
                                                echo $form->dropDownList($profile,$field->varname,Profile::range($field->range),array('class'=>'form-control'));
                                            } elseif ($field->field_type=="TEXT") {
                                                echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50, 'class'=>'form-control'));
                                            } else {
                                                echo $form->textField($profile,$field->varname,array('class'=>'form-control','size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
                                            }
                                             ?>
                                            <?php echo $form->error($profile,$field->varname); ?>
                                        </div>
                                    </div>	
                                        <?php
                                        }
                                    }
                                ?>
                        
								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-9">
                                        <?php echo CHtml::submitButton(UserModule::t("Register"), array('id'=>'reg_button', 'class'=>'btn btn-black')); ?>
									</div>
								</div>
							<!-- Password Area Ends -->
							<?php $this->endWidget(); ?>
						<!-- Registration Form Starts -->
						</div>							
					</div>
				<!-- Registration Block Ends -->
				</div>
			</div>
		</section>
	<!-- Registration Section Ends -->
    
    <?php endif; ?>
</div>