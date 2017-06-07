<?php
    /* @var $this OfferFaqController */
    /* @var $model OfferFaq */
    /* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'offer-faq-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class'=>'')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'question'); ?>
        <?php echo $form->textField($model,'question',array('class'=>'form-control')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'question'); ?></span>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'answer'); ?>
        <?php echo $form->textArea($model,'answer',array('class'=>'form-control', 'rows'=>7)); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'answer'); ?></span>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'order'); ?>
        <?php echo $form->textField($model,'order',array('class'=>'form-control')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'order'); ?></span>
    </div>

    <br />
    <div class="form-group">
        <button class="btn btn-success" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>

<?php $this->endWidget(); ?>
