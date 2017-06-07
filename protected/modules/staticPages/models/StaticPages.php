<?php

/**
 * This is the model class for table "static_pages".
 *
 * The followings are the available columns in table 'static_pages':
 * @property integer $id
 * @property integer $parent_id
 * @property string $url_name
 * @property string $menu_name
 * @property string $title
 * @property string $text
 * @property string $meta_description
 * @property string $meta_keywords
 * @property integer $order
 * @property integer $visible
 */
class StaticPages extends CActiveRecord
{
    
    public $preview_sizes = array(
        'meta_image' => array(
            array('width' => 300, 'height' => 300, 'pre' => '300'),
        )
    );
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StaticPage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'static_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url_name, title, text', 'required'),
			array('parent_id, order', 'numerical', 'integerOnly'=>true),
			array('url_name, menu_name, title, meta_title, external_link', 'length', 'max'=>255),
			array('visible', 'length', 'max'=>1),
			array('text, meta_description, meta_keywords', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, url_name, menu_name, title, text, meta_title, meta_description, meta_keywords, external_link, order, visible', 'safe'),
			array('meta_image', 'unsafe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'parent' => array(self::BELONGS_TO, 'StaticPages', 'parent_id'),
            'children' => array(self::HAS_MANY, 'StaticPages', 'parent_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
        return array(
            'id' => 'ID',
			'parent_id' => Yii::t('app', 'Parent page'),
			'url_name' => Yii::t('app', 'URL name'),
			'menu_name' => Yii::t('app', 'Menu item label'),
			'title' => Yii::t('app', 'Title'),
			'text' => Yii::t('app', 'Content'),
            'meta_title' => Yii::t('app', 'META Title'),
            'meta_description' => Yii::t('app', 'META Description'),
            'meta_keywords' => Yii::t('app', 'META Keywords'),
			'meta_image' => Yii::t('app', 'META Image'),
            'external_link' => Yii::t('app', 'External link'),
            'order' => Yii::t('app', 'Sorting order'),
            'visible' => Yii::t('app', 'Show on site'),
        );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('url_name',$this->url_name,true);
		$criteria->compare('menu_name',$this->menu_name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('external_link',$this->external_link,true);
		$criteria->compare('order',$this->order);
		$criteria->compare('visible',$this->visible,true);

        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;                
        $sort->defaultOrder = '`title` ASC';                
        $sort->multiSort = false;

        // results per page
        $pages->pageSize=Yii::app()->params['paginator_results_per_page'];
        $pages->applyLimit($criteria);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>$pages,                  
            'sort'=>$sort,
        ));
	}

    
    
	public function siteSearch($text)
	{
        $criteria=new CDbCriteria;

        $criteria->compare('url_name',$text,true,'OR');
        $criteria->compare('title',$text,true,'OR');
        $criteria->compare('menu_name',$text,true,'OR');
        $criteria->compare('text',$text,true,'OR');
        $criteria->compare('meta_title',$text,true,'OR');
        $criteria->compare('meta_description',$text,true,'OR');
        $criteria->compare('meta_keywords',$text,true,'OR');
        $criteria->compare('external_link',$text,true,'OR');

        $sort = new CSort;                
        $sort->defaultOrder = '`title` ASC';                 
        $sort->multiSort = false;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => false,                
            'sort'=>$sort,
        ));
	}
        
        
    /*
     * 
     */        
    public function getMenu($parent_id = 0, $get_children = true) 
    {               
        if ($parent_id != 0) {
            $params = array(':parent_id'=>$parent_id);
            $condition = '`parent_id` = :parent_id AND `visible` = 1';
        } else {
            $params = array();
            $condition = '`parent_id` IS NULL AND `visible` = 1';
        }

        $siblings = $this->findAll(array('condition'=>$condition, 'params'=>$params, 'order'=>'`order` ASC'));

        $arr = array();
        if (!empty($siblings)) {
            foreach ($siblings as $key => $sibling) {
                $cond = isset($_GET['url_name'])&&($_GET['url_name'] === $sibling->url_name);

                $item = array(
                    'label'=>$sibling->menu_name, 
                    'url'=>$sibling->getUrl(), 
                    'active'=> $cond
                );

                if ($get_children) {
                    $children = $this->getMenu($sibling->id, $get_children);
                    if (!empty($children))
                        $item['items'] = $children;
                }

                $arr[] = $item;
            }
        }

        return $arr;
    }


    /*
     * 
     */        
    public function getParents() 
    {                         
        if (!empty($this->parent) && !empty($this->parent->parent))
            $arr = array($this->menu_name => array('/staticPages/default/view', 'url_name'=>$this->url_name, 'parent_name'=>$this->parent->url_name, 'grandpa_name'=>$this->parent->parent->url_name));          
        else if (!empty($this->parent) && empty($this->parent->parent))
            $arr = array($this->menu_name => array('/staticPages/default/view', 'url_name'=>$this->url_name, 'parent_name'=>$this->parent->url_name));            
        else if (empty($this->parent))
            $arr = array($this->menu_name => array('/staticPages/default/view', 'url_name'=>$this->url_name));            
        if ($this->parent_id != 0) {
            $parents = $this->parent->getParents();
            $arr = array_merge($arr, $parents);
        }

        return $arr;
    }


    /*
     * 
     */
    public function scopes()
    {
        return array(
            'sitemap'=>array('select'=>'url_name', 'condition'=>'visible = 1'),
        );
    }


    /*
     * Maximum 10 inclusive layers
     */
    public function getUrl() {
        if (empty($this->external_link)) {
            $url = Yii::app()->createAbsoluteUrl('site/index');
            $url_name = $this->url_name.'.html';

            $return = $url.$url_name;
        } else {
            $return = $this->external_link;
            if (stristr($return, '://') == false)
                $return = 'http://'.$return;
        }

        return $return;
    }


    /*
     * 
     */
    public static function translit($str) {
        $str = strtr($str, array('/'=>'', '%'=>''));
        
        $str = urlencode($str);
        $output = file_get_contents(Yii::app()->params['transliteration_url'].$str);

        return $output;
    }
        
        
        
        
	/**
	 * Perform actions before deleting.
	 * @return Boolean
	 */
    protected function beforeDelete()
    {            
        $this->removeImages();
            
        if (!empty($this->children)) {
            foreach ($this->children as $key => $child) {
                $child->parent_id = $this->parent_id;
                $child->visible = 0;
                $child->save();
            }
        }

        return parent::beforeDelete();
    }
        
        
        
        
	/**
	 * Perform actions before saving.
	 * @return Boolean
	 */
    protected function beforeSave() 
    {            
        $this->prepareImages();
        
        if (empty($this->url_name))
            $this->url_name = StaticPages::translit($this->title);

        if (empty($this->menu_name))
            $this->menu_name = $this->title;

        return parent::beforeSave();
    }
    

    protected function afterSave()
    {        
        $this->saveImages();

        return parent::afterSave();
    }
    
    
    public function getSourcesPath() {
        return dirname(__FILE__).'/../../../../resources/articles/';
    }

    
    public function removeImages($only_field = NULL)
    {        
        if (!empty($this->preview_sizes)) 
            foreach ($this->preview_sizes as $field => $previews) {
                if (empty($only_field) || $only_field == $field) {
                    foreach ($previews as $preview) {
                        if (is_file($this->sourcesPath.$preview['pre'].'_'.$this->$field))
                            unlink($this->sourcesPath.$preview['pre'].'_'.$this->$field);
                    }
                    
                    if (is_file($this->sourcesPath.$this->$field))
                        unlink($this->sourcesPath.$this->$field);
                }
            }
        
        return true;
    }

    
    public function prepareImages()
    {            
        if (!empty($this->preview_sizes)) 
            foreach ($this->preview_sizes as $field => $previews) {
                $$field = CUploadedFile::getInstance($this, $field);

                if (isset($$field)) {
                    $this->removeImages($field);

                    $uname = date('YmdHis').'_'.substr(md5(uniqid(rand(), true)), 0, rand(7, 13)).'.'.$$field->extensionName;
                    $this->$field = $uname;
                }
            }
        
        return true;
    }

    
    public function saveImages()
    {    
        if (!empty($this->preview_sizes)) 
            foreach ($this->preview_sizes as $field => $previews) {
                $$field = CUploadedFile::getInstance($this, $field);

                if (isset($$field)) {
                    //save original
                    $$field->saveAs($this->sourcesPath.$this->$field);
                    
                    //generate previews
                    $this->savePreviews($field);
                }
            }    
        
        return true;
    }

    
    public function savePreviews($field)
    {    
        if (!empty($this->preview_sizes[$field])) 
            foreach ($this->preview_sizes[$field] as $preview) {
                $image_open = Yii::app()->image->load($this->sourcesPath.$this->$field);

                if (isset($preview['width']) && isset($preview['height'])) {
                    if ($image_open->width / $image_open->height > $preview['width'] / $preview['height']) $dim = Image::HEIGHT; else $dim = Image::WIDTH;
                    $image_open->resize($preview['width'], $preview['height'], $dim)->crop($preview['width'], $preview['height']);
                } elseif (isset($preview['width'])) {
                    $image_open->resize($preview['width'], $preview['width'], Image::WIDTH);
                } elseif (isset($preview['height'])) {
                    $image_open->resize($preview['height'], $preview['height'], Image::HEIGHT);
                }

                $image_open->save($this->sourcesPath.$preview['pre'].'_'.$this->$field);
            }    
        
        return true;
    }
        
        
	/**
	 * Get data formatted for DropDownLists and other
	 * @return Array
	 */
    public static function getListData($level = 0, $parent_id = NULL)
    {               
        $criteria = new CDbCriteria(array(
            'order' => '`order` ASC',
        ));

        if (!empty($parent_id)) {
            $criteria->condition = '`parent_id` = :parent_id';
            $criteria->params[':parent_id'] = $parent_id;
        } else {
            $criteria->condition = '`parent_id` IS NULL';                
        }

        $array = StaticPages::model()->findAll($criteria);      
        $list = CHtml::listData($array, 'id', 'menu_name');

        $pre = '';
        for ($i = 0; $i < $level; $i++) {$pre .= '-';}
        if (!empty($pre)) $pre .= ' ';

        $full_array = array();
        if (!empty($list)) {
            foreach ($list as $key => $item) {
                $full_array[$key] = $pre.$item;

                $child_list = StaticPages::getListData($level+1, $key);

                if (!empty($child_list)) {
                    foreach ($child_list as $key_1 => $child_item) {
                        $full_array[$key_1] = $child_item;
                    }
                }
            }
        }

        return $full_array;
    }
}