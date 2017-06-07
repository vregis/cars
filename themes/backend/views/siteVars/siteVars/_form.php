<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */

if ($model->wysiwyg_on)
    $this->widget('ImperaviRedactorWidget', array(
        'selector' => '.redactor',
        'options' => Yii::app()->params['redactor_options'],
        'plugins' => Yii::app()->params['redactor_plugins']
    ));

?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'messages-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal'),
)); 

	echo $form->errorSummary($model); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model,'name',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none">Например, COUNTERS или SIDEBAR_BLOCK. <?php echo $form->error($model,'name'); ?></span>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'value',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">            
            <?php
                if ($model->field_type == 1)
                    echo $form->textField($model,'value',array('class'=>'form-control'));
                elseif ($model->field_type == 2)
                    echo '<div class="checkbox i-checks">'.$form->checkBox($model,'value', array('value'=>'1', 'uncheckValue'=>'0')).'</div>';
                elseif ($model->field_type == 3) {
                    echo $form->fileField($model,'value');
                    if (!empty($model->value)) echo '&nbsp;&nbsp;'.CHtml::link('Посмотреть файл', Yii::app()->request->hostInfo.'/resources/vars/'.$model->value);
                } else
                    echo $form->textArea($model,'value',array('class'=>'redactor form-control', 'rows'=>12));
            ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'value'); ?></span>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'description',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'description',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'description'); ?></span>
        </div>
    </div>

    <?php if ($model->isNewRecord) { ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'field_type',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->dropDownList($model,'field_type',$model->types,array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'field_type'); ?></span>
        </div>
    </div>
    <?php } ?>

    <?php if ($model->field_type < 2) { ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'wysiwyg_on',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <div class="checkbox i-checks"><?php echo $form->checkBox($model,'wysiwyg_on', array('value'=>'1', 'uncheckValue'=>'0')); ?></div>
            <span class="help-block m-b-none"><?php echo $form->error($model,'wysiwyg_on'); ?></span>
        </div>
    </div>
    <?php } ?>

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

<!-- form -->