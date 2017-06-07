<?php
class beDatepicker extends CWidget
{
    
	public $model;
    
	public $attribute;
    
	public $htmlOptions=array('class'=>'form-control');

    
	public function init() {
        
	}
    
	public function run() {
        echo '<div class="input-group date">';
        echo '<span class="input-group-addon"><i class="fa fa-calendar"></i></span>';
        echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
        echo '</div>';
	}
}
