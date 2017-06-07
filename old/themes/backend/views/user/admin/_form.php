<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */

$user_fields = array('photo', 'city', 'lastname', 'firstname', 'middlename');

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'static-page-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data', 'class'=>''),
)); ?>

	<?php echo CHtml::errorSummary(array($model,$profile)); ?>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($profile,'lastname'); ?>
                <?php echo $form->textField($profile,'lastname',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($profile,'lastname'); ?></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($profile,'firstname'); ?>
                <?php echo $form->textField($profile,'firstname',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($profile,'firstname'); ?></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($profile,'photo'); ?><br />
        <?php echo $form->fileField($profile,'photo');
        if (!empty($profile->photo)) echo '&nbsp;&nbsp;'.CHtml::link('Посмотреть изображение', Yii::app()->request->hostInfo.'/resources/users/'.$profile->photo); 
        ?>
        <span class="help-block m-b-none"><?php echo $form->error($profile,'photo'); ?></span> 

        <?php if (!empty($profile->photo)) {?>
            <div class="checkbox">
            <?php
                echo CHtml::checkBox('photo_delete');
                echo CHtml::label('Удалить изображение','photo_delete');
            ?>
            </div>                
        <?php }?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($profile,'notes'); ?>
        <?php echo $form->textArea($profile,'notes',array('class'=>'form-control', 'rows' => 7)); ?>
        <span class="help-block m-b-none"><?php echo $form->error($profile,'notes'); ?></span>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($profile,'public_phone'); ?>
                <?php echo $form->textField($profile,'public_phone',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($profile,'public_phone'); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($profile,'country_id'); ?>
                <?php $this->widget('application.components.widgets.beSelect2',array('model'=>$profile, 'attribute'=>'country_id', 'data' => ListCountries::model()->listData, 'url' => '//listCountries/getData')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($profile,'country_id'); ?></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($profile,'city'); ?>
                <?php echo $form->textField($profile,'city',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($profile,'city'); ?></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="checkbox i-checks">
            <?php echo $form->checkBox($model,'is_approved', array('value'=>'1', 'uncheckValue'=>'0')); ?>
            <?php echo $form->labelEx($model,'is_approved'); ?>
        </div>
        <span class="help-block m-b-none"><?php echo $form->error($model,'is_approved'); ?></span>
    </div>

    <hr class="hr-line-dashed" />

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'email'); ?>
                <?php echo $form->textField($model,'email',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'email'); ?></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'password'); ?>
                <?php echo $form->passwordField($model,'password',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'password'); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'superuser'); ?>
                <?php echo $form->dropDownList($model,'superuser',User::itemAlias('AdminStatus'),array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'superuser'); ?></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'status'); ?>
                <?php echo $form->dropDownList($model,'status',User::itemAlias('UserStatus'),array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'status'); ?></span>
            </div>
        </div>
    </div>

    <hr class="hr-line-dashed" />

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'account'); ?>
                <?php echo $form->textField($model,'account',array('class'=>'form-control', 'disabled' => 'disabled')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'account'); ?></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'rating'); ?>
                <?php echo $form->textField($model,'rating',array('class'=>'form-control', 'disabled' => 'disabled')); ?>
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

<!-- form -->