<?php
    $this->pageTitle = UserModule::t("Login").' — '.Yii::app()->name;

    $this->breadcrumbs=array(
        UserModule::t("Login"),
    );
?>
<div class="container">
	<!-- Main Heading Starts -->
		<h2 class="text-center">
			Войдите или зарегистрируйтесь
		</h2>
	<!-- Main Heading Ends -->
	<!-- Login Form Section Starts -->
		<section class="registration-area">
			<div class="row">
				<div class="col-sm-6">
				<!-- Login Panel Starts -->
					<div class="panel panel-smart">
						<div class="panel-heading">
							<h3><?php echo UserModule::t("Login"); ?></h3>
						</div>
						<div class="panel-body">
                            <?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

                                <p class="thin text-center">
                                    <big>
                                        <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
                                    </big>
                                </p>

                            <?php endif; ?>
							<p>
								Пожалуйста, войдите, используя Ваш аккаунт
							</p>
						<!-- Login Form Starts -->
                        <?php echo CHtml::beginForm('', 'POST', array('class'=>'form-horizontal', 'role'=>'form')); ?>
                        
                            <p class="text-danger text-center"><?php echo CHtml::errorSummary($model); ?></p>
                            
                            <div class="form-group">
                                <?php echo CHtml::activeLabel($model,'username',array('class'=>'col-sm-4 control-label')); ?>
                                <div class="col-sm-8"><?php echo CHtml::activeTextField($model,'username',array('class'=>'form-control', 'placeholder' => 'E-mail или телефон')); ?></div>
                            </div>
                            
                            <div class="form-group">
                                <?php echo CHtml::activeLabel($model,'password',array('class'=>'col-sm-4 control-label')); ?>
                                <div class="col-sm-8"><?php echo CHtml::activePasswordField($model,'password',array('class'=>'form-control', 'placeholder' => 'Пароль')); ?></div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <div class="checkbox">
                                        <label>
                                            <?php echo CHtml::activeCheckBox($model,'rememberMe',array('value'=>'1', 'uncheckValue'=>'0')); ?> Запомнить меня
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <?php 
                                        echo '<button class="btn btn-black" type="submit">'.UserModule::t("Login").'</button>'; 
                                    ?>
                                </div>
                            </div>
						<?php echo CHtml::endForm(); ?>
						<!-- Login Form Ends -->
						</div>
					</div>
				<!-- Login Panel Ends -->
				</div>
				<div class="col-sm-6">
				<!-- Account Panel Starts -->
					<div class="panel panel-smart">
						<div class="panel-heading">
							<h3>
								Создайте новый аккаунт
							</h3>
						</div>
						<div class="panel-body">
							<p>
								Регистрация позволит хранить историю Ваших заказов и адреса доставки.
							</p>
                            <?php echo CHtml::link('Зарегистрироваться', array('/user/registration/registration'), array('class' => 'btn btn-primary')); ?>
						</div>
					</div>
				<!-- Account Panel Ends -->
				</div>
			</div>
		</section>
	<!-- Login Form Section Ends -->
    
<?php
    $form = new CForm(array(
        'elements'=>array(
            'username'=>array(
                'type'=>'text',
                'maxlength'=>32,
            ),
            'password'=>array(
                'type'=>'password',
                'maxlength'=>32,
            ),
            'rememberMe'=>array(
                'type'=>'checkbox',
            )
        ),

        'buttons'=>array(
            'login'=>array(
                'type'=>'submit',
                'label'=>'Login',
            ),
        ),
    ), $model);
?>
</div>