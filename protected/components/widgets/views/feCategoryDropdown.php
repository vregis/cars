<?php
    if (!empty($this->model))
        echo CHtml::activeHiddenField($this->model, $this->name, $this->htmlOptions);
    else
        echo CHtml::hiddenField($this->name, $this->value, $this->htmlOptions);
    
    echo CHtml::textField('', $this->publicValue, array('class'=>'catdd-selector form-control', 'data-single' => (int)$this->singleValue, 'placeholder' => Yii::t('app', 'Select types...')));