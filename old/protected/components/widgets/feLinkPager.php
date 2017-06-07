<?php
class feLinkPager extends CLinkPager
{
	const CSS_SELECTED_PAGE='active';
	public $selectedPageCssClass=self::CSS_SELECTED_PAGE;
    
	const CSS_HIDDEN_PAGE='disabled';
	public $hiddenPageCssClass=self::CSS_HIDDEN_PAGE;
    
	public $maxButtonCount=10;
    
	public $nextPageLabel='<span aria-hidden="true">&raquo;</span>';
    
	public $prevPageLabel='<span aria-hidden="true">&laquo;</span>';
    
	public $header='<nav>';
    
	public $footer='</nav>';
    
    public $htmlOptions=array('class' => 'pagination');

    
	public function init()
	{
		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='yiiPager';
        
        $this->cssFile = Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/css/pager.css';
	}

	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		// first page
		//$buttons[]=$this->createPageButton($this->firstPageLabel,0,$this->firstPageCssClass,$currentPage<=0,false);

		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$pageCount-1,false);

		// last page
		//$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,$this->lastPageCssClass,$currentPage>=$pageCount-1,false);

		return $buttons;
	}
}
