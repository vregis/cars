<?php
class beDatepickerBasic extends CWidget
{
    
	public $model;
    
	public $attribute;
    
	public $htmlOptions=array('class'=>'form-control basic-datepicker');

    
	public function init() {
        
	}
    
	public function run() {
        echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
	}
}
