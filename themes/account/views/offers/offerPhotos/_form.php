<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'photos-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'offer-photos-form')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
        <?php $this->widget('application.components.widgets.feFileField',array('model'=>$model, 'attribute'=>'filename', 'path'=>'resources/offers/', 'fieldOptions' => array('accept' => 'image/*'))) ?>
    </div>

    <br />
    <div class="form-group">
        <?php if ($model->offer->status == Offers::STATUS_PASSIVE) echo CHtml::link(Yii::t('app', 'Continue').' <i class="fa fa-angle-right"></i>', array('/offers/offerOptions/index', 'id'=>$model->offer_id), array('class' => 'btn btn-muted pull-right')) ?>
    </div>

<?php $this->endWidget(); ?>
