<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'photos-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'filename'); ?><br />
        <?php echo $form->fileField($model,'filename[]',array('multiple'=>true));
        if (!empty($model->filename)) echo '&nbsp;&nbsp;'.CHtml::link('Посмотреть изображение', Yii::app()->request->hostInfo.'/resources/offers/'.$model->filename); 
        ?>
        <span class="help-block m-b-none">Рекомендуемый размер более 1200px по ширине. <?php echo $form->error($model,'filename'); ?></span>
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
