<?php
class feSingleCategoryDropdown extends CWidget
{    
	public $model = '';
    
    public $name = '';
    
    public $value = '';
    
    public $publicValue = '';
    
    public $htmlOptions = array(
        'class'=>'form-control', 
        'autocomplete'=>'off',
        'class'=>'single-category-select',
    );
    
    
	public function init()
	{
        $name = $this->name;
        $this->value = $this->model->$name;
        
        $this->htmlOptions['empty'] = Yii::t('app', 'Select category...');
        Yii::app()->controller->singleCategoryDropdown = true;
        
        if (!empty($this->value)) {
            $category = Categories::model()->findByPk($this->value);

            $this->publicValue = $category->name;
        }
	}
    

	public function run()
	{        
        $this->render('feSingleCategoryDropdown', array());
	}
}