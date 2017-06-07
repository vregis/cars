<?php
    /* @var $this OfferAddressesController */
    /* @var $model OfferAddresses */
    /* @var $form CActiveForm */
    
    if (!empty($model->country_id)) {        
        $raw_data = ListProvinces::model()->findAll(array(
            'condition' => '`country_id` = :country_id',
            'params' => array(':country_id' => $model->country_id),
        ));
        $provinces_list = CHtml::listData($raw_data, 'id', function($data) {return $data->name;});
    } else 
        $provinces_list = array();
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'offer-addresses-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class'=>'')
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'country_id',array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model,'country_id',ListCountries::model()->listData,array('class'=>'form-control', 'empty'=>'Выберите страну...', 'id'=>'field-country-id')); ?>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'province_id',array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model,'province_id',$provinces_list,array(
                    'class'=>'form-control', 
                    'empty'=>'Выберите область/провинцию...', 
                    'id'=>'field-province-id',
                    'data-url' => Yii::app()->createAbsoluteUrl('//listProvinces/getDataByCountry', array())
                )); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'city'); ?>
                <?php echo $form->textField($model,'city',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'city'); ?></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'address'); ?>
                <?php echo $form->textField($model,'address',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'address'); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'zip'); ?>
                <?php echo $form->textField($model,'zip',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'zip'); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'lat'); ?>
                <?php echo $form->textField($model,'lat',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'lat'); ?></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'lng'); ?>
                <?php echo $form->textField($model,'lng',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'lng'); ?></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="checkbox i-checks">
            <?php echo $form->checkBox($model,'is_primary', array('value'=>'1', 'uncheckValue'=>'0')); ?>
            <?php echo $form->labelEx($model,'is_primary'); ?>
        </div>
        <span class="help-block m-b-none"><?php echo $form->error($model,'is_primary'); ?></span>
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
