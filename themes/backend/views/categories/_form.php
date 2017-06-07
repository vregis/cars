<?php
    /* @var $this CategoriesController */
    /* @var $model Categories */
    /* @var $form CActiveForm */

    $this->widget('ImperaviRedactorWidget', array(
        'selector' => '.redactor',    
        'options' => Yii::app()->params['redactor_options'],
        'plugins' => Yii::app()->params['redactor_plugins']
    ));
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'categories-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'name'); ?></span>
        </div>
    </div>
<!--
	<div class="form-group">
		<?php echo $form->labelEx($model,'description',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textArea($model,'description',array('class'=>'form-control redactor')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'description'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'url_name',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'url_name',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none">Оставить незаполненным для автогенерации. <?php echo $form->error($model,'url_name'); ?></span>
        </div>
    </div>
-->
	<div class="form-group">
		<?php echo $form->labelEx($model,'parent_id',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->dropDownList($model,'parent_id',Categories::getListData(),array('empty'=>'Корневая категория', 'class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'parent_id'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'order',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'order',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'order'); ?></span>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'visible',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <div class="checkbox i-checks"><?php echo $form->checkBox($model,'visible', array('value'=>'1', 'uncheckValue'=>'0')); ?></div>
            <span class="help-block m-b-none"><?php echo $form->error($model,'visible'); ?></span>
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
