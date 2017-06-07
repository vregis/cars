<?php
    /* @var $this OfferAddressesController */
    /* @var $model OfferAddresses */
    /* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'offer-addresses-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class'=>'')
)); ?>

	<?php $this->renderPartial('_fields', array('form' => $form, 'model' => $model)); ?>

    <br />
    <div class="form-group">
        <button class="btn btn-success" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>

<?php $this->endWidget();
