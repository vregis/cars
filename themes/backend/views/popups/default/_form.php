<?php
    /* @var $this PopupsController */
    /* @var $model Popups */
    /* @var $form CActiveForm */

    $this->widget('ImperaviRedactorWidget', array(
        'selector' => '.redactor',    
        'options' => Yii::app()->params['redactor_options'],
        'plugins' => Yii::app()->params['redactor_plugins']
    ));
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'popups-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'title'); ?></span>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'image',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->fileField($model,'image');
            if (!empty($model->image)) echo '&nbsp;&nbsp;'.CHtml::link('Посмотреть изображение', Yii::app()->request->hostInfo.'/resources/popups/'.$model->image); 
            ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'image'); ?></span> 
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'link',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'link',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'link'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'html',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textArea($model,'html',array('class'=>'form-control', 'rows'=>7)); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'html'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'delay',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'delay',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'delay'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'period',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'period',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'period'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'date_expires',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php $this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_expires')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'date_expires'); ?></span>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <?php
                if ($model->isNewRecord) 
                    echo '<button class="btn btn-primary" type="submit">Добавить</button>'; 
                else 
                    echo '<button class="btn btn-success" type="submit">Сохранить</button>'; 
            ?>
        </div>
    </div>

<?php $this->endWidget(); ?>
