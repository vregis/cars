<?php

?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'parameter-values-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class'=>'form-horizontal')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
        <div class="col-xs-6">
            <div class="input-group">
                <?php echo $form->textField($model,'value',array('class'=>'form-control', 'placeholder'=>'Добавьте новое значение...')); ?>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </span>
            </div>
            <span class="help-block m-b-none"><?php echo $form->error($model,'value'); ?></span>
        </div>
    </div>    

<?php $this->endWidget(); ?>
