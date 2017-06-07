<?php
    /* @var $this PrivateMessagesController */
    /* @var $model PrivateMessages */
    /* @var $form CActiveForm */

    $this->widget('ImperaviRedactorWidget', array(
        'selector' => '.redactor',    
        'options' => Yii::app()->params['redactor_options'],
        'plugins' => Yii::app()->params['redactor_plugins']
    ));
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'private-messages-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'recepient_id',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'recepient_id'); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'recepient_id'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'sender_id',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'sender_id'); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'sender_id'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'text',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textArea($model,'text',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'text'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'date_created',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'attribute'=>'date_created',
                'language' => 'ru',
                'i18nScriptFile' => 'jquery.ui.datepicker-ru.js',
                // additional javascript options for the date picker plugin
                'options'=>array(
                    'showAnim'=>'fade',
                    'showOtherMonths' => true,
                    'selectOtherMonths' => true,
                    'showOn' => 'focus',
                    'format' => 'yy-mm-dd',
                    'dateFormat' => 'yy-mm-dd',
                    'buttonImage' => Yii::app()->theme->baseUrl.'/images/calendar-month.png',
                    'buttonImageOnly' => true
                ),
                'cssFile' => 'jquery-ui-1.10.4.custom.min.css',
                'theme' => 'mscms',
                'themeUrl' => Yii::app()->theme->baseUrl.'/css',
                'htmlOptions'=>array(
                    'class'=>'datepicker form-control'
                ),
            ));
            ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'date_created'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'is_seen',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'is_seen'); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'is_seen'); ?></span>
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
