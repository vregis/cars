<?php
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subscribers-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row form-group">
        <div class="col-sm-4">
            <?php echo $form->labelEx($model,'name',array('class'=>'control-label')); ?>
            <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'name'); ?></span>
        </div>
    </div>

	<div class="row form-group">
        <div class="col-sm-4">
            <?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
            <?php echo $form->textField($model,'email',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'email'); ?></span>
        </div>
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
