<?php

?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'enableAjaxValidation' => false,
    'action' => array('dialog', 'id' => $model->recepient_id)
)); ?>

    <br />

    <p class="hide-dialog"><?= CHtml::link('<i class="fa fa-eye-slash"></i>&nbsp;&nbsp;&nbsp;'.Yii::t('app', 'Hide all dialog'), array('hide', 'id'=>$model->recepient_id)) ?></p>
    
    <div class="form-group">
        <?php echo $form->textArea($model,'text',array('class' => 'form-control', 'rows' => '3', 'placeholder' => Yii::t('app', 'Your message...'), 'id' => 'dialog-text')); ?>
    </div>

    <div class="form-group text-right" style="padding-bottom: 10px;">
        <button class="btn btn-success" data-id="<?= $model->recepient_id ?>" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>

<?php $this->endWidget();
