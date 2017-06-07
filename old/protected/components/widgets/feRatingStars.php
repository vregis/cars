<?php
class feRatingStars extends CWidget
{    
	public $htmlOptions=array('class' => '');
    
    public $rating;
    
    
	public function init()
	{
		if (empty($this->rating) || ($this->rating < 1))
            $this->rating = 1;
        
        if (round ($this->rating) != $this->rating)
            $this->rating = round ($this->rating);
	}
    

	public function run()
	{
		echo CHtml::openTag('p', $this->htmlOptions);
        for ($i = 1; $i <= $this->rating; $i++) {
            echo '<i class="fa fa-star"></i>';
        }
        for ($i = ($this->rating+1); $i <= 5; $i++) {
            echo '<i class="fa fa-star-o"></i>';
        }
        echo CHtml::closeTag('p');
	}
}