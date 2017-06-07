<?php
class beCombobox extends CWidget
{        
    public $model;
    
    public $attribute;
    
    public $data;
    
    public $htmlOptions;
    
	public function init()
	{
        
	}
    
	public function run()
	{
        if (!empty($this->htmlOptions)) {
            if (!empty($this->htmlOptions['class']))
                $this->htmlOptions['class'] .= ' chosen-select';
                        
            if (empty($this->htmlOptions['data-placeholder']))
                $this->htmlOptions['data-placeholder'] = 'Выберите из списка...';
                        
            if (empty($this->htmlOptions['empty']))
                $this->htmlOptions['empty'] = 'Не выбрано';
        }
        
        echo '<div class="input-group combobox-group">'.CHtml::activeDropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions).'</div>';
	}
}
