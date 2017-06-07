<?php
Yii::import('zii.widgets.grid.CGridView');

class feGridView extends CGridView
{    
	public $showTableOnEmpty=true;
    
	public $ajaxUpdate=false;
    
	public $beforeAjaxUpdate;
    
	public $afterAjaxUpdate='gridUpdate';
    
	public $selectableRows=0;
    
	public $cssFile=false;
    
	public $itemsCssClass='table table-striped table-hover';
    
	public $template='{items}{pager}';
    
	public $pager=array('class'=>'application.components.widgets.feLinkPager');
    
    public $htmlOptions = array('class'=>'grid-view');
    
	public $summaryText = false;
    
    public $enableSorting = false;
    
    
	public function renderSummary()
	{
		if(($count=$this->dataProvider->getItemCount())<=0)
			return;
        
        echo '<div class="col-lg-4">';
		//echo CHtml::openTag($this->summaryTagName, array('class'=>$this->summaryCssClass));
		if($this->enablePagination)
		{
			$pagination=$this->dataProvider->getPagination();
			$total=$this->dataProvider->getTotalItemCount();
			$start=$pagination->currentPage*$pagination->pageSize+1;
			$end=$start+$count-1;
			if($end>$total)
			{
				$end=$total;
				$start=$end-$count+1;
			}
			if(($summaryText=$this->summaryText)===null)
				$summaryText=Yii::t('zii','Displaying {start}-{end} of 1 result.|Displaying {start}-{end} of {count} results.',$total);
			echo strtr($summaryText,array(
				'{start}'=>$start,
				'{end}'=>$end,
				'{count}'=>$total,
				'{page}'=>$pagination->currentPage+1,
				'{pages}'=>$pagination->pageCount,
			));
		}
		else
		{
			if(($summaryText=$this->summaryText)===null)
				$summaryText=Yii::t('zii','Total 1 result.|Total {count} results.',$count);
			echo strtr($summaryText,array(
				'{count}'=>$count,
				'{start}'=>1,
				'{end}'=>$count,
				'{page}'=>1,
				'{pages}'=>1,
			));
		}
		//echo CHtml::closeTag($this->summaryTagName);
        echo '</div>';
	}
    
    
	public function renderPager()
	{
		if(!$this->enablePagination)
			return;
                
		$pager=array();
		$class='CLinkPager';
		if(is_string($this->pager))
			$class=$this->pager;
		elseif(is_array($this->pager))
		{
			$pager=$this->pager;
			if(isset($pager['class']))
			{
				$class=$pager['class'];
				unset($pager['class']);
			}
		}
		$pager['pages']=$this->dataProvider->getPagination();
		if($pager['pages']->getPageCount()>1)
		{
			$this->widget($class,$pager);
		}
		else
			$this->widget($class,$pager);
	}
}
