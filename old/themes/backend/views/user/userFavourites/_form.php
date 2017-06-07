<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-favourites-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class'=>'')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'offer_id'); ?>
        <?php $this->widget(
            'application.components.widgets.beSelect2',
            array(
                'model'=>$model, 
                'attribute'=>'offer_id', 
                'data'=>Offers::getData(),
                'url'=>'/offers/default/getData',
                'htmlOptions'=>array('class' => 'form-control')
            )
        ); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'offer_id'); ?></span>
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
