<?php
    /* @var $this OfferReviewsController */
    /* @var $model OfferReviews */
    /* @var $form CActiveForm */
?>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <?php echo $form->labelEx($model,'text'); ?>
                <?php echo $form->textArea($model,'text',array('class'=>'form-control', 'rows'=>7)); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'text'); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'rating'); ?>
                <?php echo $form->dropDownList($model,'rating',array(1, 2, 3, 4, 5),array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'rating'); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <?php echo $form->labelEx($photomodel,'filename'); ?><br />
                <?php $this->widget('application.components.widgets.feFileField',array('model'=>$photomodel, 'attribute'=>'filename', 'fieldOptions' => array('accept' => 'image/*', 'multiple'=>true))) ?>
            </div>
        </div>
    </div>