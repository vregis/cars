<?php $this->pageTitle='Смена пароля - '.Yii::app()->name;
?>
<h1><?php echo CHtml::link('Профиль', array('/user/profile/edit')); ?> / Форма смены пароля</h1>


<div class="form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'changepassword-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="row odd">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password'); ?>
	<?php echo $form->error($model,'password'); ?>
	<p class="hint">
	<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
	</p>
	</div>
	
	<div class="row">
	<?php echo $form->labelEx($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword'); ?>
	<?php echo $form->error($model,'verifyPassword'); ?>
	<p class="hint">
	&nbsp;
	</p>
	</div>
	
	
	<div class="align_center">
            <br /><br />
	<?php echo CHtml::submitButton(UserModule::t("Save"), array('class'=>'btn btn-red')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->