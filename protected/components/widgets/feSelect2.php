<?php
class feSelect2 extends CWidget
{        
    public $model;
    
    public $attribute;
    
    public $data;
    
    public $url;
    
    public $htmlOptions = array();
    
	public function init()
	{
        
	}
    
	public function run()
	{
        if (empty($this->htmlOptions['class']))
            $this->htmlOptions['class'] = 'form-control large-select';
        
        if (!empty($this->htmlOptions['class']) && !stristr($this->htmlOptions['class'], 'large-select'))
            $this->htmlOptions['class'] .= ' large-select';
        
        if (!empty($this->htmlOptions['class']) && !stristr($this->htmlOptions['class'], 'form-control'))
            $this->htmlOptions['class'] .= ' form-control';
        
        if (empty($this->htmlOptions['empty']))
            $this->htmlOptions['empty'] = 'Выберите из списка...';        
        
        $this->htmlOptions['data-ajax-url'] = Yii::app()->createAbsoluteUrl($this->url);
        
        echo CHtml::activeDropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);
	}
}
