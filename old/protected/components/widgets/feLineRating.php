<?php
class feLineRating extends CWidget
{        
    public $rating = 0;
    
    public $percent = 0;
    
    public $class = '';
    
    public $htmlOptions = array('class' => 'col-xs-8 parameter-value');
    
    public $showRating = true;
    
    
	public function init()
	{
		$this->percent = round($this->rating / 5 * 100);
        if ($this->rating >= 4)
            $this->class = 'text-success';
        else
            $this->class = 'text-danger';
	}
    

	public function run()
	{   
        echo CHtml::openTag('div', $this->htmlOptions);
        
        echo '<div class="parameter-line-cover"><div class="parameter-line '.$this->class.'" style="width: '.$this->percent.'%;"></div></div>';
        
        if ($this->showRating)
            echo '<span class="'.$this->class.'">'.$this->rating.'</span>';
        
        echo CHtml::closeTag('div');
	}
}