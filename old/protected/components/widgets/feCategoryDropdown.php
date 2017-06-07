<?php
class feCategoryDropdown extends CWidget
{    
	public $model = '';
    
	public $name = '';    
    public $value = '';
    
    public $publicValue = '';
    
    public $singleValue = false;
    
    public $htmlOptions = array(
        'class'=>'form-control', 
        'autocomplete'=>'off',
        'id'=>'search-type',
    );
    
    
	public function init()
	{
        $this->htmlOptions['empty'] = Yii::t('app', 'Select category...');
        Yii::app()->controller->categoryDropdown = $this->render('feCategoryDropdownBottom', array(), true);
        
        if (!empty($this->model)) {
            $name = $this->name;
            $this->value = Yii::t('categories', $this->model->$name);
        }
        
        if (!empty($this->value)) {
            $types = explode(',', $this->value);
            
            if (!empty($types)) {
                $criteria = new CDbCriteria();
                $criteria->addInCondition('id', $types);
                $selected_categories = Categories::model()->findAll($criteria);

                $publicValueArr = array();
                if (!empty($selected_categories))
                    foreach ($selected_categories as $category) {
                        $publicValueArr[] = Yii::t('categories', $category->name);
                    }
                $this->publicValue = implode(', ', $publicValueArr);
            }
        }
	}
    

	public function run()
	{        
        $this->render('feCategoryDropdown', array());
	}
}