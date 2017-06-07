<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orders-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class'=>'')
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'offer_id'); ?>
                <?php 
                    $this->widget(
                        'application.components.widgets.beSelect2',
                        array(
                            'model'=>$model, 
                            'attribute'=>'offer_id', 
                            'data'=>Offers::getData(), 
                            'url'=>'/offers/default/getData', 
                            'htmlOptions'=>array('class' => 'form-control')
                        )
                    ); 
                ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'offer_id'); ?></span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'client_id'); ?>
                <?php 
                    $this->widget(
                        'application.components.widgets.beSelect2',
                        array(
                            'model'=>$model, 
                            'attribute'=>'client_id', 
                            'data'=>Profile::getClientsData(), 
                            'url'=>'/user/clients/getData', 
                            'htmlOptions'=>array('class' => 'form-control')
                        )
                    ); 
                ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'client_id'); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'date_since'); ?>
                <?php $this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_since')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'date_since'); ?></span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'date_for'); ?>
                <?php $this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_for')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'date_for'); ?></span>
            </div>
        </div>
    </div>

    <?php if (!$model->isNewRecord) { ?>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'address_from'); ?>
                <?php echo $form->dropDownList($model,'address_from',$model->offer->getAddressesList(),array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'address_from'); ?></span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'address_to'); ?>
                <?php echo $form->dropDownList($model,'address_to',$model->offer->getAddressesList(),array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'address_to'); ?></span>
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'price_type'); ?>
                <?php echo $form->dropDownList($model,'price_type',$model->prices_types,array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'price_type'); ?></span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'discount'); ?>
                <?php echo $form->textField($model,'discount',array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'discount'); ?></span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'total_cost'); ?>
                <?php echo $form->textField($model,'total_cost',array('class'=>'form-control', 'disabled'=>'disabled')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'total_cost'); ?></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'notes'); ?>
        <?php echo $form->textArea($model,'notes',array('class'=>'form-control')); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'notes'); ?></span>
    </div>

    <?php if (!$model->isNewRecord) { ?>
    <hr class="hr-line-dashed" />
    
    <h4>Дополнительные опции</h4>

    <div class="form-group">
        <div class="checkbox checkbox-list">
            <?php echo CHtml::checkBoxList('OfferOptions', $a_options, CHtml::listData($model->offer->options, 'id', 'title')); ?>
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
