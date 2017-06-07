<?php
Yii::import('zii.widgets.CListView');

class feListView extends CListView
{        
	public $ajaxUpdate=false;
    
	public $cssFile=false;
    
	public $template='{items}{pager}';
    
	public $pager=array('class'=>'application.components.widgets.feLinkPager');    
}
