<?php
    echo CHtml::activeHiddenField($this->$model, $this->$name, $this->htmlOptions);
    echo CHtml::textField('', $this->publicValue, array('class' => 'sc-public-value', 'class'=>'form-control', 'placeholder' => Yii::t('app', 'Select type...')));