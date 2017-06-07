<?php
class feDatepicker extends CWidget
{
    
	public $model;
    
	public $attribute;
    
	public $htmlOptions=array('class'=>'form-control');
    
	public $time = true;

    
	public function init() {
        
	}
    
	public function run() {
        if ($this->time)
            $class = 'date';
        else
            $class = 'datepicker';
        
        echo '<div class="input-group '.$class.'">';
        echo '<span class="input-group-addon"><i class="fa fa-calendar"></i></span>';
        echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
        echo '</div>';
	}
}