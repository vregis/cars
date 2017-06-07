<?php
    /* @var $this OfferOptionsController */
    /* @var $model OfferOptions */
    /* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'offer-options-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class'=>'')
)); ?>

	<?php echo $form->errorSummary($model); ?>
    <?php echo CHtml::activeHiddenField($model,'main_option_id', array('id' => 'main_option_id'));?>
    <div class="row">     
        <div class="form-group">
            <div class="checkbox i-checks">
                <?php echo $form->checkBox($model,'visible', array('value'=>'1', 'uncheckValue'=>'0')); ?>
                <?php echo $form->labelEx($model,'visible'); ?>
            </div>
            <span class="help-block m-b-none"><?php echo $form->error($model,'visible'); ?></span>
        </div>
    </div>
    <div class= "row">
    	<div class="form-group">
    		<?php echo $form->labelEx($model,'title'); ?>
            <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'title'); ?></span>
        </div>
    
    </div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('class'=>'form-control', 'rows' => 5)); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'description'); ?></span>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'price_daily'); ?>
                <?php echo $form->textField($model,'price_daily',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'price_daily'); ?></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'order'); ?>
        <?php echo $form->textField($model,'order',array('class'=>'form-control')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'order'); ?></span>
    </div> 

    

    <br />
    <div class="form-group">
        <button class="btn btn-success" type="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>

<?php $this->endWidget(); ?>
