<?php
Yii::import('zii.widgets.CMenu');

class feMainMenu extends CMenu
{
	public $activateParents=true;
    
	public $htmlOptions=array('class' => '');
    
	public $submenuHtmlOptions=array();
    
    public $lastItemCssClass = 'last';
    
    public $id = 'top-menu';

	/**
	 * Recursively renders the menu items.
	 * @param array $items the menu items to be rendered recursively
	 */
	protected function renderMenuRecursive($items)
	{
		$count=0;
		$n=count($items);
		foreach($items as $item)
		{
			$count++;
			$options=isset($item['itemOptions']) ? $item['itemOptions'] : array();
            
            if(isset($item['items']) && count($item['items'])) {
                $class=array('dropdown');                
            } else
                $class=array();
			if($item['active'] && $this->activeCssClass!='')
				$class[]=$this->activeCssClass;
			if($count===1 && $this->firstItemCssClass!==null)
				$class[]=$this->firstItemCssClass;
			if($count===$n && $this->lastItemCssClass!==null)
				$class[]=$this->lastItemCssClass;
			if($this->itemCssClass!==null)
				$class[]=$this->itemCssClass;
			if($class!==array())
			{
				if(empty($options['class']))
					$options['class']=implode(' ',$class);
				else
					$options['class'].=' '.implode(' ',$class);
			}

			echo CHtml::openTag('li', $options);

			$menu=$this->renderMenuItem($item);
			if(isset($this->itemTemplate) || isset($item['template']))
			{
				$template=isset($item['template']) ? $item['template'] : $this->itemTemplate;
				echo strtr($template,array('{menu}'=>$menu));
			}
			else
				echo $menu;

			if(isset($item['items']) && count($item['items']))
			{
                $subitems = false;
                foreach ($item['items'] as $subItem) {
                    if (!empty($subItem['items']) && count($subItem['items']))
                        $subitems = true;
                }
                
                if ($subitems) {
                    echo '<div class="dropdown-menu"><div class="dropdown-inner">';
                    foreach ($item['items'] as $subItem) {                        
                        echo "\n".CHtml::openTag('ul',array('class' => 'list-unstyled'))."\n";
                        echo '<li class="dropdown-header">'.$subItem['label'].'</li>';
                        if(isset($subItem['items']) && count($subItem['items']))
                            $this->renderMenuRecursive($subItem['items']);
                        echo CHtml::closeTag('ul')."\n";                        
                    }
                    echo '</div></div>';
                } else {
                    echo "\n".CHtml::openTag('ul',isset($item['submenuOptions']) ? $item['submenuOptions'] : $this->submenuHtmlOptions)."\n";
                    $this->renderMenuRecursive($item['items']);
                    echo CHtml::closeTag('ul')."\n";
                }
			}

			echo CHtml::closeTag('li')."\n";
		}
	}
    
    
    
	protected function renderMenuItem($item)
	{
		if(isset($item['url']))
		{
			$label=$this->linkLabelWrapper===null ? $item['label'] : CHtml::tag($this->linkLabelWrapper, $this->linkLabelWrapperHtmlOptions, $item['label']);
            
            $linkOptions = array();
            if (isset($item['linkOptions']))
                $linkOptions = $item['linkOptions'];
            
            if (!empty($item['items'])) {
                if (!empty($linkOptions['class']))
                    $linkOptions['class'] .= ' dropdown-toggle';
                else
                    $linkOptions['class'] = 'dropdown-toggle';
                $linkOptions['data-toggle'] = 'dropdown';
                $linkOptions['data-hover'] = 'dropdown';
                $linkOptions['data-delay'] = '10';
            }
            
			return CHtml::link($label,$item['url'],$linkOptions);
		}
		else
			return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
	}
}