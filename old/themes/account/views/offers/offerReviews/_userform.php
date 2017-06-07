

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'text'); ?>
        <?php echo $form->textArea($model,'text',array('class'=>'form-control', 'rows'=>7)); ?>
        <span class="help-block m-b-none"><?php echo $form->error($model,'text'); ?></span>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'parameter_1'); ?>
                <?php echo $form->dropDownList($model,'parameter_1',array(1=>1,2=>2,3=>3,4=>4,5=>5),array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'parameter_1'); ?></span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'parameter_2'); ?>
                <?php echo $form->dropDownList($model,'parameter_2',array(1=>1,2=>2,3=>3,4=>4,5=>5),array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'parameter_2'); ?></span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'parameter_3'); ?>
                <?php echo $form->dropDownList($model,'parameter_3',array(1=>1,2=>2,3=>3,4=>4,5=>5),array('class'=>'form-control')); ?>
                <span class="help-block m-b-none"><?php echo $form->error($model,'parameter_3'); ?></span>
            </div>
        </div>
    </div>