<?php
    /* @var $this OfferDocumentsController */
    /* @var $model OfferDocuments */
    /* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'offer-documents-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'title'); ?></span>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'filename'); ?>
        <br />
        <?php $this->widget('application.components.widgets.feFileField',array('model'=>$model, 'attribute'=>'filename', 'path'=>'resources/documents/')) ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'filename'); ?></span> 
    </div>

    <br />
    <div class="form-group">
        <button class="btn btn-success" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>

<?php $this->endWidget();
