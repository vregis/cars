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

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'date_since'); ?>
                <?php $this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_since')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'date_since'); ?></span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'date_for'); ?>
                <?php $this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_for')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'date_for'); ?></span>
            </div>
        </div>
    </div>

    <br />
    <div class="form-group">
        <button class="btn btn-success" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>

<?php $this->endWidget();
