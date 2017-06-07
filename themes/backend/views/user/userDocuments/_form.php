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
		<?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'title'); ?></span>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'filename'); ?>
        <br />
        <?php echo $form->fileField($model,'filename');
        if (!empty($model->filename)) echo '&nbsp;&nbsp;'.CHtml::link('Посмотреть файл', Yii::app()->request->hostInfo.'/resources/documents/'.$model->filename); 
        ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'filename'); ?></span> 
    </div>

    <div class="form-group">
        <?php
            if ($model->isNewRecord) 
                echo '<button class="btn btn-primary" type="submit">Добавить</button>'; 
            else 
                echo '<button class="btn btn-success" type="submit">Сохранить</button>'; 
        ?>
    </div>

<?php $this->endWidget();
