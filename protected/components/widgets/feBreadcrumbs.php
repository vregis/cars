<?php
Yii::import('zii.widgets.CBreadcrumbs');

class feBreadcrumbs extends CBreadcrumbs
{            
	public $htmlOptions=array('class'=>'breadcrumbs');

	public $separator=' <i class="fa fa-angle-right breadcrumbs-separator"></i> ';
    
	public function run()
	{
		if(empty($this->links))
			return;

		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
        echo '<div class="container">';
		$links=array();
		if($this->homeLink===null)
			$links[]=CHtml::link(Yii::t('zii','Home'),Yii::app()->homeUrl);
		elseif($this->homeLink!==false)
			$links[]=$this->homeLink;
		foreach($this->links as $label=>$url)
		{
			if(is_string($label) || is_array($url))
				$links[]=strtr($this->activeLinkTemplate,array(
					'{url}'=>CHtml::normalizeUrl($url),
					'{label}'=>$this->encodeLabel ? CHtml::encode($label) : $label,
				));
			else
				$links[]=str_replace('{label}',$this->encodeLabel ? CHtml::encode($url) : $url,$this->inactiveLinkTemplate);
		}
        
		echo implode($this->separator,$links);
        echo CHtml::link('Need Help?', array('/staticPages/default/view', 'url_name' => 'how-it-works'), array('class' => 'pull-right'));
        echo '</div>';
		echo CHtml::closeTag($this->tagName);
	}
}