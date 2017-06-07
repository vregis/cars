<?php
    $this->pageTitle = Yii::t('app', 'My Settings').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Profile') => array('/user/profile/edit'),
        Yii::t('app', 'My Settings')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'My Settings') ?></h3>
        
        
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <h4><?= Yii::t('app', 'Current Presets') ?></h4>
                
                <?php $form=$this->beginWidget('UActiveForm', array(
                    'id'=>'profile-form',
                    'enableAjaxValidation'=>true,
                )); ?>
                
                    <div class="form-group">
                        <label for="language-change-control" class="control-label"><?= Yii::t('app', 'Language') ?></label>
                        <?= CHtml::dropDownList('language-change-control', Yii::app()->language, Yii::app()->params['languages'], array('class' => 'form-control')); ?>
                    </div>

                    <div class="form-group">
                        <label for="currency-change-control" class="control-label"><?= Yii::t('app', 'Currency') ?></label>
                        <?= CHtml::dropDownList('currency-change-control', Yii::app()->params['currency']['id'], Currencies::model()->listData, array('class' => 'form-control')); ?>
                    </div>

                    <div class="form-group">
                        <br />
                        <?php echo CHtml::link(Yii::t('app', 'Save changes').' <i class="fa fa-angle-right"></i>', '#', array('class' => 'btn btn-success btn-submit', 'data-target' => 'profile-form')); ?>
                    </div>

                <?php $this->endWidget(); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-1">
            </div>
        </div>
    </div>