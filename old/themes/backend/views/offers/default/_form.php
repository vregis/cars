<?php
    /* @var $this OffersController */
    /* @var $model Offers */
    /* @var $form CActiveForm */

    $this->widget('ImperaviRedactorWidget', array(
        'selector' => '.redactor',    
        'options' => Yii::app()->params['redactor_options'],
        'plugins' => Yii::app()->params['redactor_plugins']
    ));
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'offers-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'')
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'title'); ?>
                <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'title'); ?></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'category_id'); ?>
                <?php echo $form->dropDownList($model,'category_id',Categories::getListDataGrouped(),array('class' => 'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'category_id'); ?></span>
            </div>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('class'=>'form-control', 'rows'=>'5')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'description'); ?></span>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'rental_information'); ?>
        <?php echo $form->textArea($model,'rental_information',array('class'=>'form-control redactor')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'rental_information'); ?></span>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'video_link'); ?>
                <?php echo $form->textField($model,'video_link',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'video_link'); ?></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'year'); ?>
                <?php echo $form->textField($model,'year',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'year'); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'price_daily'); ?>
                <?php echo $form->textField($model,'price_daily',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'price_daily'); ?></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'price_hourly'); ?>
                <?php echo $form->textField($model,'price_hourly',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'price_hourly'); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'owner_id'); ?>
                <?php 
                    $this->widget(
                        'application.components.widgets.beSelect2',
                        array(
                            'model'=>$model, 
                            'attribute'=>'owner_id', 
                            'data'=>Profile::getClientsData(), 
                            'url'=>'/user/clients/getData', 
                            'htmlOptions'=>array('class' => 'form-control')
                        )
                    ); 
                ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'owner_id'); ?></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'status'); ?>
                <?php echo $form->dropDownList($model,'status',$model->statuses,array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'status'); ?></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'is_approved',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
            <div class="checkbox i-checks"><?php echo $form->checkBox($model,'is_approved', array('value'=>'1', 'uncheckValue'=>'0')); ?></div>
            <span class="help-block m-b-none"><?php echo $form->error($model,'is_approved'); ?></span>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'is_promo',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
            <div class="checkbox i-checks"><?php echo $form->checkBox($model,'is_promo', array('value'=>'1', 'uncheckValue'=>'0')); ?></div>
            <span class="help-block m-b-none"><?php echo $form->error($model,'is_promo'); ?></span>
        </div>
    </div>

    <?php if (!$model->isNewRecord) { ?>
    <hr class="hr-line-dashed" />
    
    <h4>Адреса приема/сдачи</h4>

    <div class="form-group">
        <div class="checkbox">
            <?php echo CHtml::checkBoxList('UserAddresses', $a_addresses, CHtml::listData($model->owner->addresses, 'id', function($data) {return $data->fullAddress;})); ?>
        </div>
    </div>
    <?php } ?>

    <div class="form-group">
        <?php
            if ($model->isNewRecord) 
                echo '<button class="btn btn-primary" type="submit">Добавить</button>'; 
            else 
                echo '<button class="btn btn-success" type="submit">Сохранить</button>'; 
        ?>
    </div>

<?php $this->endWidget(); ?>
