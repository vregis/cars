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
        <?php echo $form->labelEx($model,'notes'); ?>
        <?php echo $form->textArea($model,'notes',array('class'=>'form-control')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'notes'); ?></span>
    </div>

    <?php if (!$model->isNewRecord && !empty($model->offer->options)) { ?>
    <hr class="hr-line-dashed" />
    
    <h4><?= Yii::t('app', 'Additional Options') ?></h4>

    <div class="form-group">
        <div class="checkbox">
            <?php echo CHtml::checkBoxList('OfferOptions', $a_options, CHtml::listData($model->offer->options, 'id', 'title')); ?>
        </div>
    </div>
    <?php } ?>

    <?php
    if (in_array($model->status, array(Orders::STATUS_NEW))) {
    ?>
    <br />
    <div class="form-group">
        <button class="btn btn-success" type="submit"><?= Yii::t('app', 'Save changes') ?></button>
    </div>
    <?php } ?>

<?php $this->endWidget();
