<?php
    $this->pageTitle = Yii::t('app', '2. Photos & Docs').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'Photos & Docs')
    );
    
    if (!empty($profile->province_id)) {
        $profile->country = $profile->province->country_id;
        
        $raw_data = ListProvinces::model()->findAll(array(
            'condition' => '`country_id` = :country_id',
            'params' => array(':country_id' => $profile->country),
        ));
        $provinces_list = CHtml::listData($raw_data, 'id', function($data) {return $data->fullName;});
    } else 
        $provinces_list = array();
?>


    <div class="account-content">
        <h3><?= Yii::t('app', 'Profile Information') ?></h3>
        <br />

        <?php $this->renderPartial('_tabs', array('model' => $model)) ?>
        <br />
        
        <?php $form=$this->beginWidget('UActiveForm', array(
            'id'=>'profile-form',
            'enableAjaxValidation'=>true,
            'htmlOptions' => array('enctype'=>'multipart/form-data'),
        )); ?>
        
        <div class="row">
            <div class="col-xs-12 col-sm-7">  
                <p class="small-lead">Please, upload more photos about yourself.</p>
                <div class="row">
                    <div class="col-xs-12 col-sm-4"> 
                        <?= CHtml::image($profile->getSquarePhoto('photo'), $profile->name, array('class' => 'img-responsive', 'id' => 'profile-img-cont-1')); ?>

                        <div class="photo-delete-panel">
                            <div>
                            <?php 
                            if (!empty($profile->photo))
                                echo CHtml::link('<i class="fa fa-times"></i>', array('deletePhoto', 't'=>0), array('confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'class'=>'pull-right'));

                            echo CHtml::activeFileField($profile, 'photo', array(
                                'class' => 'hidden profile-image-file', 
                                'accept' => 'image/*', 
                                'data-success-cont' => '#profile-img-cont-1',
                                'data-form' => 'profile-form',
                                'data-url' => $this->createAbsoluteUrl('/user/profile/savePhoto/type/photo'),
                            ));
                            echo CHtml::link('<i class="fa fa-download"></i>'.Yii::t('app', 'Upload...'), '#', array('confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'class'=>'profile-image'));
                            ?>
                            </div>
                        </div>    
                        
                        <p class="text-center text-thin text-muted" style="margin: 10px 0;">Portrait / Avatar <sup class="text-success">(+ 30%)</sup></p>
                    </div> 
                    <div class="col-xs-12 col-sm-4">                
                        <?= CHtml::image($profile->getSquarePhoto('photo2'), $profile->name, array('class' => 'img-responsive', 'id' => 'profile-img-cont-2')); ?>

                        <div class="photo-delete-panel">
                            <div>
                            <?php 
                            if (!empty($profile->photo2))
                                echo CHtml::link('<i class="fa fa-times"></i>', array('deletePhoto', 't'=>1), array('confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'class'=>'pull-right'));

                            echo CHtml::activeFileField($profile, 'photo2', array(
                                'class' => 'hidden profile-image-file', 
                                'accept' => 'image/*', 
                                'data-success-cont' => '#profile-img-cont-2',
                                'data-form' => 'profile-form',
                                'data-url' => $this->createAbsoluteUrl('/user/profile/savePhoto/type/photo2'),
                            ));
                            echo CHtml::link('<i class="fa fa-download"></i>'.Yii::t('app', 'Upload...'), '#', array('confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'class'=>'profile-image'));
                            ?>
                            </div>
                        </div>
                        
                        <p class="text-center text-thin text-muted" style="margin: 10px 0;">Another portrait <sup class="text-success">(+ 30%)</sup></p>
                    </div>
                    <div class="col-xs-12 col-sm-4">                
                        <?= CHtml::image($profile->getSquarePhoto('photo3'), $profile->name, array('class' => 'img-responsive', 'id' => 'profile-img-cont-3')); ?>

                        <div class="photo-delete-panel">
                            <div>
                            <?php 
                            if (!empty($profile->photo3))
                                echo CHtml::link('<i class="fa fa-times"></i>', array('deletePhoto', 't'=>2), array('confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'class'=>'pull-right'));

                            echo CHtml::activeFileField($profile, 'photo3', array(
                                'class' => 'hidden profile-image-file', 
                                'accept' => 'image/*', 
                                'data-success-cont' => '#profile-img-cont-3',
                                'data-form' => 'profile-form',
                                'data-url' => $this->createAbsoluteUrl('/user/profile/savePhoto/type/photo3'),
                            ));
                            echo CHtml::link('<i class="fa fa-download"></i>'.Yii::t('app', 'Upload...'), '#', array('confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'class'=>'profile-image'));
                            ?>
                            </div>
                        </div>
                        
                        <p class="text-center text-thin text-muted" style="margin: 10px 0;">And one more... <sup class="text-success">(+ 30%)</sup></p>
                    </div>
                </div>
                
                <hr />
                
                <p class="small-lead">Upload scan of your ID card (or equal document). <sup class="text-success">(+ 90%)</sup></p>
                
                <?php $this->renderPartial('/userDocuments/gridview', array('model'=>$userDocumentModel)); ?>
                
                

                <div class="form-group">
                    <?php echo $form->labelEx($userDocument,'title'); ?>
                    <?php echo $form->textField($userDocument,'title',array('class'=>'form-control')); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($userDocument,'filename'); ?>
                    <br />
                    <?php $this->widget('application.components.widgets.feFileField',array('model'=>$userDocument, 'attribute'=>'filename', 'path'=>'resources/documents/')) ?>
                </div>

                <br /><br />
                <div class="form-group text-right">
                    <?php echo CHtml::link(Yii::t('app', 'Save & Continue').' <i class="fa fa-angle-right"></i>', 'stage3', array('class' => 'btn btn-success btn-submit', 'data-target' => 'profile-form')); ?>
                </div>
            </div>
                                    
            <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                <?php $this->renderPartial('_stats', array('model' => $model)); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>