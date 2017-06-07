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


    <div class="form-group">
        <?php
            if ($model->isNewRecord) 
                echo '<button class="btn btn-primary" type="submit">Добавить</button>'; 
            else 
                echo '<button class="btn btn-success" type="submit">Сохранить</button>'; 
        ?>
    </div>

<?php $this->endWidget(); ?>
