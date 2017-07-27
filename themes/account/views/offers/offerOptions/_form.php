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
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">

                <?php echo CHtml::dropDownList('dsds', $model->main_option_id, $model->getListDataMainOption($model->offer_id),
                    array(
                        'ajax' => array(
                            'type'=>'POST', //request type
                            'url'=>$this->createUrl('/offers/offerOptions/addreplace',array('id'=>$model->main_option_id,)), //url to call.
                            'data'=>array('mo'=>'js:$(this).val()'),
                            'success'=>'function(data){location.reload();}'
                            //Style: CController::createUrl('currentController/methodToCall')
                            //'update'=>'#city_id', //selector to update
                            //'data'=>'js:javascript statement' 
                            //leave out the data key to pass all form values through
                        ),
                        'class'=>'form-control'
                    )
                );
                ?>
            </div>
        </div>
        <div class="col-xs-2 col-sm-2">
            <div class="form-group">
                <button class="btn btn-success" type="submit" name="submit" value="addad" style="height:32px;"><?= Yii::t('app', 'Add Adition') ?></button>
            </div>
        </div>
        <div class="col-xs-2 col-sm-2">
            <!--<div class="form-group">
                <div class="checkbox i-checks" style="margin: 0px;">
                    <?php echo $form->checkBox($model,'use_paypal'); ?>
                    <?php echo $form->labelEx($model,'use_paypal',array('style'=>'margin:0px;')); ?>
                </div>
                <span class="help-block m-b-none"><?php echo $form->error($model,'use_paypal'); ?></span>
            </div>-->
        </div>
        <div class="col-xs-2 col-sm-2">
            <div class="form-group">
                <div class="checkbox i-checks" style="margin: 0px;">
                    <?php echo $form->checkBox($model,'visible', array('value'=>'1', 'uncheckValue'=>'0')); ?>
                    <?php echo $form->labelEx($model,'visible',array('style'=>'margin:0px;')); ?>
                </div>
                <span class="help-block m-b-none"><?php echo $form->error($model,'visible'); ?></span>
            </div>
        </div>
    </div>
    <div class= "row">
        <div class="col-xs-12 col-sm-12"> 
        	<div class="form-group">
        		<?php echo $form->labelEx($model,'title'); ?>
                <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'title'); ?></span>
            </div>
        </div>
    </div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('class'=>'form-control', 'rows' => 5)); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'description'); ?></span>
    </div>

    <div class="row">
        <div class="col-xs-2 col-sm-2">
            <div class="form-group">
                <?php echo $form->labelEx($model,'price_daily'); ?>
                <?php echo $form->textField($model,'price_daily',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'price_daily'); ?></span>
            </div>
        </div>
    </div>
    <div class="row"> 
        <div class="col-xs-2 col-sm-2">
            <div class="form-group">
                <?php echo $form->labelEx($model,'order'); ?>
                <?php echo $form->textField($model,'order',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'order'); ?></span>
            </div>
        </div> 
    </div>
 <!--<div class="row">
<div class="col-xs-4 col-sm-4">
    <h3>Working Hours</h3>  
    <div class="row" style="margin-top:15px;">
        <div class="col-xs-1 col-sm-1" style="margin-right:20px;"><?php echo $form->labelEx($model,'mon'); ?></div><div class="col-xs-2 col-sm-2"><?php echo $form->textField($model,'mon'); ?></div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-xs-1 col-sm-1" style="margin-right:20px;"><?php echo $form->labelEx($model,'tue'); ?></div><div class="col-xs-2 col-sm-2"><?php echo $form->textField($model,'tue'); ?></div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-xs-1 col-sm-1" style="margin-right:20px;"><?php echo $form->labelEx($model,'wed'); ?></div><div class="col-xs-2 col-sm-2"><?php echo $form->textField($model,'wed'); ?></div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-xs-1 col-sm-1" style="margin-right:20px;"><?php echo $form->labelEx($model,'thu'); ?></div><div class="col-xs-2 col-sm-2"><?php echo $form->textField($model,'thu'); ?></div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-xs-1 col-sm-1" style="margin-right:20px;"><?php echo $form->labelEx($model,'fri'); ?></div><div class="col-xs-2 col-sm-2"><?php echo $form->textField($model,'fri'); ?></div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-xs-1 col-sm-1" style="margin-right:20px;"><?php echo $form->labelEx($model,'sat'); ?></div><div class="col-xs-2 col-sm-2"><?php echo $form->textField($model,'sat'); ?></div>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="col-xs-1 col-sm-1" style="margin-right:20px;"><?php echo $form->labelEx($model,'sun'); ?></div><div class="col-xs-2 col-sm-2"><?php echo $form->textField($model,'sun'); ?></div>
    </div>
    </div>
    </div>-->
    <br />
    <div class="form-group">
        <button class="btn btn-success" type="submit" name="submit" value="submit"><?= Yii::t('app', 'Submit') ?></button>
    </div>

<?php $this->endWidget(); ?>
