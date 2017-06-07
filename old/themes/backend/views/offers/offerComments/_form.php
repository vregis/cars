<?php
    /* @var $this OfferCommentsController */
    /* @var $model OfferComments */
    /* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'offer-comments-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class'=>'')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'author_id'); ?>
        <?php 
            $this->widget(
                'application.components.widgets.beSelect2',
                array(
                    'model'=>$model, 
                    'attribute'=>'author_id', 
                    'data'=>Profile::getClientsData(), 
                    'url'=>'/user/clients/getData', 
                    'htmlOptions'=>array('class' => 'form-control')
                )
            ); 
        ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'author_id'); ?></span>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'text'); ?>
        <?php echo $form->textArea($model,'text',array('class'=>'form-control', 'rows'=>7)); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'text'); ?></span>
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
