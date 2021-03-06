<?php
    /* @var $this PlacesController */
    /* @var $model Places */
    /* @var $form CActiveForm */

    $this->widget('ImperaviRedactorWidget', array(
        'selector' => '.redactor',    
        'options' => Yii::app()->params['redactor_options'],
        'plugins' => Yii::app()->params['redactor_plugins']
    ));
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'places-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'type',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->dropDownList($model,'type',$model->types,array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'type'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'name'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'province_id',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php $this->widget('application.components.widgets.beSelect2',array('model'=>$model, 'attribute'=>'province_id', 'data' => ListProvinces::model()->listData, 'url' => '//listProvinces/getData')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'province_id'); ?></span>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'address',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'address',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'address'); ?></span>
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
