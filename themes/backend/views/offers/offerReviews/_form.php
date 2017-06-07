<?php
    /* @var $this OfferReviewsController */
    /* @var $model OfferReviews */
    /* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'offer-reviews-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class'=>'')
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'text'); ?>
                <?php echo $form->textArea($model,'text',array('class'=>'form-control', 'rows'=>7)); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'text'); ?></span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'response'); ?>
                <?php echo $form->textArea($model,'response',array('class'=>'form-control', 'rows'=>7)); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'response'); ?></span>
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


    <div class="form-group">
        <?php
            if ($model->isNewRecord) 
                echo '<button class="btn btn-primary" type="submit">Добавить</button>'; 
            else 
                echo '<button class="btn btn-success" type="submit">Сохранить</button>'; 
        ?>
    </div>

<?php $this->endWidget(); ?>
