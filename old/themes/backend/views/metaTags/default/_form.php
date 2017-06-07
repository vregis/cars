<?php
/* @var $this MetaTagsController */
/* @var $model MetaTags */
/* @var $form CActiveForm */

$this->widget('ImperaviRedactorWidget', array(
    'selector' => '.redactor',    
    'options' => Yii::app()->params['redactor_options'],
    'plugins' => Yii::app()->params['redactor_plugins']
));

?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'meta-tags-form',
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

	<div class="form-group">
		<?php echo $form->labelEx($model,'route',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'route',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none">Например, "site/index". См. <?php echo CHtml::link('Routes для Yii Framework', 'http://yiiframework.ru/doc/guide/ru/topics.url'); ?>.<?php echo $form->error($model,'route'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'title'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'description',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textArea($model,'description',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'description'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'keywords',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textArea($model,'keywords',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'keywords'); ?></span>
        </div>
    </div>  

    <div class="form-group">
        <?php echo $form->labelEx($model,'image',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->fileField($model,'image');
            if (!empty($model->image)) echo '&nbsp;&nbsp;'.CHtml::link('Посмотреть изображение', Yii::app()->request->hostInfo.'/resources/articles/'.$model->image); 
            ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'image'); ?></span> 

            <?php if (!empty($model->image)) {?>
                <div class="checkbox-inline checkbox">
                <?php
                    echo CHtml::checkBox('image_delete');
                    echo CHtml::label('Удалить изображение','image_delete');
                ?>
                </div>                
            <?php }?>
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
