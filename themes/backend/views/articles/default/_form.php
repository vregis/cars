<?php
/* @var $this ArticlesController */
/* @var $model Articles */
/* @var $form CActiveForm */

$this->widget('ImperaviRedactorWidget', array(
    'selector' => '.redactor',    
    'options' => Yii::app()->params['redactor_options'],
    'plugins' => Yii::app()->params['redactor_plugins']
));

?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'articles-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'category_id',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
            <?php echo $form->dropDownList($model,'category_id',$model->categories,array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'category_id'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
            <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'title'); ?></span>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'image',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
            <?php echo $form->fileField($model,'image');
            if (!empty($model->image)) echo '&nbsp;&nbsp;'.CHtml::link('Посмотреть изображение', Yii::app()->request->hostInfo.'/resources/articles/'.$model->image); 
            ?>
            <span class="help-block m-b-none">Размер изображения 1200х300. <?php echo $form->error($model,'image'); ?></span> 

            <?php if (!empty($model->image)) {?>
                <div class="checkbox-inline">
                <?php
                    echo CHtml::checkBox('image_delete');
                    echo CHtml::label('Удалить изображение','image_delete');
                ?>
                </div>                
            <?php }?>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'annotation',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
            <?php echo $form->textArea($model,'annotation',array('class'=>'redactor form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'annotation'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'text',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
            <?php echo $form->textArea($model,'text',array('class'=>'redactor form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'text'); ?></span>
        </div>
    </div>
    
    <?php
    if (!$model->isNewRecord) {
    ?>

    <div class="hr-line-dashed"></div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'meta_title',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
            <?php echo $form->textField($model,'meta_title',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'meta_title'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'meta_description',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
            <?php echo $form->textArea($model,'meta_description',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'meta_description'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'meta_keywords',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
            <?php echo $form->textArea($model,'meta_keywords',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'meta_keywords'); ?></span>
        </div>
    </div>
    
    <?php
    }
    ?>

    <div class="hr-line-dashed"></div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'url_name',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
            <?php echo $form->textField($model,'url_name',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none">Оставить незаполненным для автогенерации. <?php echo $form->error($model,'url_name'); ?></span>
        </div>
    </div>
    
    <?php
    if (!$model->isNewRecord) {
    ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'date_created',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
            <?php $this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_created')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'date_created'); ?></span>
        </div>
    </div>
    
    <?php
    }
    ?>

    <div class="form-group">
        <?php echo $form->labelEx($model,'visible',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
            <div class="checkbox i-checks"><?php echo $form->checkBox($model,'visible', array('value'=>'1', 'uncheckValue'=>'0')); ?></div>
            <span class="help-block m-b-none"><?php echo $form->error($model,'visible'); ?></span>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
            <?php
                if ($model->isNewRecord) 
                    echo '<button class="btn btn-primary btn-lg" type="submit">Добавить</button>'; 
                else 
                    echo '<button class="btn btn-success btn-lg" type="submit">Сохранить</button>'; 
            ?>
        </div>
    </div>

<?php $this->endWidget(); ?>
