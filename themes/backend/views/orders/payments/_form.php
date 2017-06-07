<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'payments-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class'=>'')
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'order_id'); ?>
                <?php echo $form->textField($model,'order_id',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'order_id'); ?></span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'amount'); ?>
                <?php echo $form->textField($model,'amount',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'amount'); ?></span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'transfer_number'); ?>
                <?php echo $form->textField($model,'transfer_number',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'transfer_number'); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'payment_type'); ?>
                <?php echo $form->dropDownList($model,'payment_type',PaymentTypes::model()->getListData(), array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'payment_type'); ?></span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'country'); ?>
                <?php echo $form->dropDownList($model,'country',ListCountries::model()->getList(),array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'country'); ?></span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'payer_name'); ?>
                <?php echo $form->textField($model,'payer_name',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'payer_name'); ?></span>
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
