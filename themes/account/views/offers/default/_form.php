<?php
    /* @var $this OfferDocumentsController */
    /* @var $model OfferDocuments */
    /* @var $form CActiveForm */

    $this->widget('ImperaviRedactorWidget', array(
        'selector' => '.redactor',    
        'options' => Yii::app()->params['public_redactor_options'],
        'plugins' => Yii::app()->params['public_redactor_plugins']
    ));
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'offer-documents-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'')
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <?php 
    if (!isset($_GET['master'])) {
    ?>

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
                <?php 
                    $this->widget('application.components.widgets.feCategoryDropdown', array(
                        'model'=>$model,
                        'name' => 'category_id',
                        'singleValue' => true
                    )); 
                ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'category_id'); ?></span>
            </div>
        </div>
    </div>

    <?php
    if (!$model->isNewRecord) {
    ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status',$model->statuses,array('class'=>'form-control')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'status'); ?></span>
    </div>
    <?php
    }
    ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('class'=>'form-control', 'rows'=>'5')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'description'); ?></span>
    </div>

    <div class="row">
        <div class="col-sm-7">
            <div class="form-group">
                <?php echo $form->labelEx($model,'rental_information'); ?>
                <?php echo $form->textArea($model,'rental_information',array('class'=>'form-control redactor')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'rental_information'); ?></span>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <br /><br /><br /><br />
                <p>Please, describe such issues, as:</p>
                <ul>
                    <li>Is prepayment required?</li>
                    <li>Do you need pledge?</li>
                    <li>Are there any age restrictions?</li>
                    <li>Additional equipment, license etc</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'video_link'); ?>
                <?php echo $form->textField($model,'video_link',array('class'=>'form-control', 'placeholder' => 'https://www.youtube.com/watch?v=hFHf...')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'video_link'); ?></span>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <?php echo $form->labelEx($model,'year'); ?>
                <?php echo $form->textField($model,'year',array('class'=>'form-control', 'placeholder' => date('Y'))); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'year'); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
           
                <?php echo $form->labelEx($model,'age_from');?>
            
        </div>
    </div>

   <!-- <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
                <?php //echo $form->labelEx($model,'paypal_id'); ?>
                <?php //echo $form->textField($model,'paypal_id',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php //echo $form->error($model,'paypal_id'); ?></span>
            </div>
        </div>
    </div>-->

    <div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->labelEx($model,'phone'); ?>
            <?php echo $form->textField($model,'phone',array('class'=>'form-control')); ?>
            <span class="help-block m-b-none"><?php echo $form->error($model,'phone'); ?></span>
        </div>
    </div>
    </div>


    <?php 
    }
    ?>

    <?php if (!$model->isNewRecord) { ?>
    <hr class="hr-line-dashed" />
    
    <h4><?= Yii::t('app', 'Addresses of reception/return') ?></h4>

    <div class="form-group">
        <div class="checkbox">
            <?php echo CHtml::checkBoxList('UserAddrCheckboxes', $a_addresses, CHtml::listData($model->owner->addresses, 'id', function($data) {return $data->fullAddress;})); ?>
        </div>
    </div>
    
    <?php 
    
        if (isset($_GET['master'])) {
            if (!empty($model->owner->addresses)) echo '<h4>'.Yii::t('app', 'or add new address').'</h4>';
            $this->renderPartial('//user/userAddresses/_fields', array('form' => $form, 'model' => $address_model));
        }
    
    } ?>

    <br />
    <div class="form-group text-right">
        <?php
        if ($model->isNewRecord || isset($_GET['master']) || ($model->status == Offers::STATUS_PASSIVE)) {
            echo '<button class="btn btn-muted" type="submit" name="save">'.Yii::t('app', 'Save').' <i class="fa fa-angle-right"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            echo '<button class="btn btn-success" type="submit" name="continue">'.Yii::t('app', 'Save & Continue').' <i class="fa fa-angle-right"></i></button>';
        } else
            echo '<button class="btn btn-success" type="submit">'.Yii::t('app', 'Save').'</button>';
        ?>
    </div>

<?php $this->endWidget();
