<?php
/* @var $this ParametersController */
/* @var $model Parameters */
/* @var $form CActiveForm */

?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'parameters-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class'=>'')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'name'); ?></span>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'order'); ?>
        <?php echo $form->textField($model,'order',array('class'=>'form-control')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'order'); ?></span>
    </div>

    <div class="form-group">
        <?php
            if ($model->isNewRecord) 
                echo '<button class="btn btn-primary btn-lg" type="submit">Добавить</button>'; 
            else 
                echo '<button class="btn btn-success btn-lg" type="submit">Сохранить</button>'; 
        ?>
    </div>

<?php $this->endWidget(); ?>
