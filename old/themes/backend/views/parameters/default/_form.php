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
		<?php echo $form->labelEx($model,'group_id'); ?>
        <?php echo $form->dropDownList($model,'group_id',ParameterGroups::model()->listData,array('class'=>'form-control')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'group_id'); ?></span>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'type'); ?>
        <?php echo $form->dropDownList($model,'type',$model->types,array('class'=>'form-control')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'type'); ?></span>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'order'); ?>
        <?php echo $form->textField($model,'order',array('class'=>'form-control')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'order'); ?></span>
    </div>

    <div class="form-group">
        <div class="checkbox i-checks">
            <?php echo $form->checkBox($model,'is_required', array('value'=>'1', 'uncheckValue'=>'0')); ?>
            <?php echo $form->labelEx($model,'is_required'); ?>
        </div>
        <span class="help-block m-b-none"><?php echo $form->error($model,'is_required'); ?></span>
    </div>

    <?php if (!$model->isNewRecord && count($model->values)) { ?>
    <hr class="hr-line-dashed" />
    
    <h4>Список значений</h4>

    <p>
        <?php 
            echo implode(', ', array_values($model->valuesData)); 
            echo ' — '.CHtml::link('изменить значения', array('/parameters/parameterValues/admin', 'id' => $model->id));
        ?>
    </p>
    
    <hr class="hr-line-dashed" />
    <?php } ?>

    <div class="form-group">
        <?php
            if ($model->isNewRecord) 
                echo '<button class="btn btn-primary btn-lg" type="submit">Добавить</button>'; 
            else 
                echo '<button class="btn btn-success btn-lg" type="submit">Сохранить</button>'; 
        ?>
    </div>

<?php $this->endWidget(); ?>
