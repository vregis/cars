<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */

$this->widget('ImperaviRedactorWidget', array(
    'selector' => '.redactor',
    'options' => Yii::app()->params['redactor_options'],
    'plugins' => Yii::app()->params['redactor_plugins']
));

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'static-page-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal')
)); ?>

	
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php if ($model->isNewRecord) echo 'Добавление страницы'; else echo 'Страница «'.$model->menu_name.'» <small>'.CHtml::link('Перейти на страничку', $model->getUrl()).'</small>'; ?></h5>

                        <div class="ibox-tools">
                            <span class="label label-danger">* отмечены обязательные поля.</span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <?php echo $form->errorSummary($model); ?>
                        
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'title',array('class'=>'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo $form->textField($model,'title',array('required'=>'required', 'class'=>'form-control')); ?>
                                <span class="help-block m-b-none"><?php echo $form->error($model,'title'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model,'text',array('class'=>'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo $form->textArea($model,'text',array('class'=>'redactor form-control')); ?>
                                <span class="help-block m-b-none"><?php echo $form->error($model,'text'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model,'url_name',array('class'=>'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo $form->textField($model,'url_name',array('class'=>'form-control')); ?>
                                <span class="help-block m-b-none">Оставить незаполненным для автогенерации. <?php echo $form->error($model,'url_name'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model,'menu_name',array('class'=>'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo $form->textField($model,'menu_name',array('class'=>'form-control')); ?>
                                <span class="help-block m-b-none"><?php echo $form->error($model,'menu_name'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model,'parent_id',array('class'=>'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo $form->dropDownList($model,'parent_id',StaticPages::getListData(),array('empty'=>'Корневая страница', 'class'=>'form-control')); ?>
                                <span class="help-block m-b-none"><?php echo $form->error($model,'parent_id'); ?></span>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model,'meta_title',array('class'=>'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo $form->textField($model,'meta_title',array('class'=>'form-control')); ?>
                                <span class="help-block m-b-none"><?php echo $form->error($model,'meta_title'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model,'meta_description',array('class'=>'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo $form->textArea($model,'meta_description',array('class'=>'form-control')); ?>
                                <span class="help-block m-b-none"><?php echo $form->error($model,'meta_description'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model,'meta_keywords',array('class'=>'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo $form->textField($model,'meta_keywords',array('class'=>'form-control')); ?>
                                <span class="help-block m-b-none"><?php echo $form->error($model,'meta_keywords'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model,'meta_image',array('class'=>'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo $form->fileField($model,'meta_image');
                                if (!empty($model->meta_image)) echo '&nbsp;&nbsp;'.CHtml::link('Посмотреть изображение', Yii::app()->request->hostInfo.'/resources/articles/'.$model->meta_image); 
                                ?>
                                <span class="help-block m-b-none"><?php echo $form->error($model,'meta_image'); ?></span> 

                                <?php if (!empty($model->meta_image)) {?>
                                    <div class="checkbox-inline checkbox">
                                    <?php
                                        echo CHtml::checkBox('meta_image_delete');
                                        echo CHtml::label('Удалить изображение','meta_image_delete');
                                    ?>
                                    </div>                
                                <?php }?>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model,'order',array('class'=>'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo $form->textField($model,'order',array('class'=>'form-control', 'required'=>'required')); ?>
                                <span class="help-block m-b-none"><?php echo $form->error($model,'order'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                                <?php echo $form->labelEx($model,'external_link',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->textField($model,'external_link',array('class'=>'form-control')); ?>
                                    <span class="help-block m-b-none">Используйте для установки ссылки на другие сайты. <?php echo $form->error($model,'external_link'); ?></span>
                                </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->labelEx($model,'visible',array('class'=>'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <div class="checkbox i-checks"><?php echo $form->checkBox($model,'visible', array('value'=>'1', 'uncheckValue'=>'0')); ?></div>
                                <span class="help-block m-b-none"><?php echo $form->error($model,'visible'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <?php 
                                    if ($model->isNewRecord) 
                                        echo '<button class="btn btn-primary" type="submit">Добавить</button>'; 
                                    else 
                                        echo '<button class="btn btn-success" type="submit">Сохранить</button>'; 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>

<!-- form -->