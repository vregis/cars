<?php

/**
 * This is the model class for table "categories".
 *
 * The followings are the available columns in table 'categories':
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $url_name
 * @property string $description
 * @property integer $order
 * @property integer $visible
 *
 * The followings are the available model relations:
 * @property Offers[] $offers
 * @property ParametersCategories[] $parametersCategories
 */
class Categories extends CActiveRecord
{

    public $fn;
    public $ln;
    public $photo;
    public $filename;
    public $title;
    public $descr;
    public $offer_id;
    public $owner_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Categories the static model class
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
		return 'categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('parent_id, order, visible', 'numerical', 'integerOnly'=>true),
			array('name, url_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, name, url_name, description, order, visible', 'safe'),
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
            'parent' => array(self::BELONGS_TO, 'Categories', 'parent_id'),
            'children' => array(self::HAS_MANY, 'Categories', 'parent_id', 'order' => '`order` ASC'),
			'offers' => array(self::HAS_MANY, 'Offers', 'category_id', 'order' => '`date_created` DESC'),
			'parametersCategories' => array(self::HAS_MANY, 'ParametersCategories', 'category_id'),
			'parameters' => array(self::MANY_MANY, 'Parameters', 'parameters_categories(category_id, parameter_id)', 'order' => '`order` ASC'),
			'preoptions' => array(self::HAS_MANY, 'Preoptions', 'category_id', 'order' => '`title` ASC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => Yii::t('app', 'Parent category'),
			'name' => Yii::t('app', 'Name'),
			'url_name' => Yii::t('app', 'URL name'),
			'description' => Yii::t('app', 'Description'),
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
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url_name',$this->url_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('order',$this->order);
		$criteria->compare('visible',$this->visible);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`order` ASC, `name` ASC';
        //$sort->multiSort = true;

        // results per page
        $pages->pageSize=50;
        $pages->applyLimit($criteria);

		return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>$pages,
            'sort'=>$sort,
		));
	}
        
        
	/**
	 * Special scope for sitemap extension.
	 * @return Array
	 */
    public function scopes()
    {
        return array(
            'sitemap'=>array('select'=>'url_name', 'condition'=>'visible = 1'),
        );
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
	 * Remove resources and related models.
	 * @return Boolean
	 */
    protected function beforeDelete()
    {         
        if (!empty($this->offers)) {
            $this->addError('id', 'Нельзя удалить категорию, в которой есть предложения.');
            
            return false;
        }
            
        if (!empty($this->children))
            foreach ($this->children as $category) {
                $category->parent_id = $this->parent_id;
                $category->save();
            }
            
        if (!empty($this->parametersCategories))
            foreach ($this->parametersCategories as $pc) {
                $pc->delete();
            }
           
        return parent::beforeDelete();
    }
        
        
	/**
	 * Save resources and do preparations.
	 * @return Boolean
	 */
    protected function beforeSave()
    {
        //if (empty($this->url_name))
        //    $this->url_name = Categories::translit($this->name);
        
        return parent::beforeSave();
    }
        
        
	/**
	 * Get data formatted for DropDownLists and other
	 * @return Array
	 */
    public static function getListData($level = 0, $parent_id = NULL)
    {               
        $criteria = new CDbCriteria(array(
            'order' => '`order` ASC, `name` ASC',
        ));

        if (!empty($parent_id)) {
            $criteria->condition = '`parent_id` = :parent_id';
            $criteria->params[':parent_id'] = $parent_id;
        } else {
            $criteria->condition = '`parent_id` IS NULL';                
        }

        $array = Categories::model()->findAll($criteria);      
        $list = CHtml::listData($array, 'id', 'name');

        $pre = '';
        for ($i = 0; $i < $level; $i++) {$pre .= '-';}
        if (!empty($pre)) $pre .= ' ';

        $full_array = array();
        if (!empty($list)) {
            foreach ($list as $key => $item) {
                $full_array[$key] = $pre.$item;

                $child_list = Categories::getListData($level+1, $key);

                if (!empty($child_list))                     
                    foreach ($child_list as $key_1 => $child_item) {
                        $full_array[$key_1] = $child_item;
                    }
            }
        }

        return $full_array;
    }
        
        
	/**
	 * Get data formatted for DropDownLists and other
	 * @return Array
	 */
    public static function getListDataWithoutChildren($parent_id)
    {               
        $criteria = new CDbCriteria(array(
            'order' => '`order` ASC, `name` ASC',
        ));
        $criteria->condition = '`parent_id` = :parent_id';
        $criteria->params[':parent_id'] = $parent_id;

        $array = Categories::model()->findAll($criteria);      

        $full_array = array();
        if (!empty($array)) 
            foreach ($array as $category) {
                $cat_name = Yii::t('categories', $category->name);
            
                if (empty($category->children))
                    $label = $cat_name;
                else
                    $label = $cat_name.'<i class="fa fa-angle-right"></i>';
                
                $class = '';
                if (isset($_GET['t']) && !empty($_GET['t'])) {
                    $types = explode(',', $_GET['t']);
                    $active = in_array($category->id, $types);
                    
                    $children_ids = $category->getChildrenIds();
                    if (!empty($types))
                        foreach ($types as $type) {
                            if (in_array($type, $children_ids))
                                $class = 'selected';
                        }
                } else 
                    $active = false;
            
                $item_array = array(
                    'label' => $label,
                    'url' => '#',
                    'active' => $active,
                    'linkOptions' => array('data-id' => $category->id),
                    'itemOptions' => array('class' => $class),
                );
                
                $full_array[] = $item_array;
            }

        return $full_array;
    }
        
        
	/**
	 * Get grouped data formatted for DropDownLists and other
	 * @return Array
	 */
    public static function getListDataGrouped()
    {               
        $criteria = new CDbCriteria(array(
            'condition' => '`t`.`parent_id` IS NOT NULL AND `t`.parent_id NOT IN (1,2,3)',
            'with' => array('parent'),
            'order' => '`parent`.`order` ASC, `t`.`order` ASC',
        ));

        $array = Categories::model()->findAll($criteria);      
        $list = CHtml::listData($array, 'id', 'name', function($data) {return $data->parent->parent->name;});

        return $list;
    }
        
        
	/**
	 * Get grouped data formatted for DropDownLists and other
	 * @return Array
	 */
    public static function getDescribedListData($pre = '', $parent_id = NULL)
    {               
        $criteria = new CDbCriteria(array(
            'order' => '`order` ASC, `name` ASC',
        ));

        if (!empty($parent_id)) {
            $criteria->condition = '`parent_id` = :parent_id';
            $criteria->params[':parent_id'] = $parent_id;
        } else {
            $criteria->condition = '`parent_id` IS NULL';                
        }

        $array = Categories::model()->findAll($criteria);      
        $list = CHtml::listData($array, 'id', 'name');

        $full_array = array();
        if (!empty($list)) {
            foreach ($list as $key => $item) {
                if (!empty($pre))
                    $label = $pre.' / '.$item;
                else
                    $label = $item;
                
                $full_array[$key] = $label;

                $child_list = Categories::getDescribedListData($label, $key);

                if (!empty($child_list))                     
                    foreach ($child_list as $key_1 => $child_item) {
                        $full_array[$key_1] = $child_item;
                    }
            }
        }

        return $full_array;
    }
        
        
	/**
	 * Get data formatted for DropDownLists and other
	 * @return Array
	 */
    public static function getMenu($parent_id = 0)
    {               
        $criteria = new CDbCriteria(array(
            'condition' => '`parent_id` = :parent_id',
            'params' => array(':parent_id' => $parent_id),
            'order' => '`order` ASC, `name` ASC',
        ));

        $array = Categories::model()->findAll($criteria);      
        $list = CHtml::listData($array, 'id', 'name');

        $full_array = array();
        if (!empty($list)) 
            foreach ($list as $id => $name) {
                $item_array = array(
                    'label' => $name,
                    'url' => '#',
                    'linkOptions' => array('data-id' => $id),
                );

                $children = Categories::getMenu($id);
                if (!empty($children)) 
                    $item_array['items'] = $children;
                
                $full_array[] = $item_array;
            }

        return $full_array;
    }
        
        
	/**
	 * @return Array
	 */
    public static function getAdminMenu($parent_id = NULL)
    {               
        if (empty($parent_id))
            $criteria = new CDbCriteria(array(
                'condition' => '`parent_id` IS NULL',
                'order' => '`order` ASC, `name` ASC',
            ));
        else
            $criteria = new CDbCriteria(array(
                'condition' => '`parent_id` = :parent_id',
                'params' => array(':parent_id' => $parent_id),
                'order' => '`order` ASC, `name` ASC',
            ));

        $array = Categories::model()->findAll($criteria);      
        $list = CHtml::listData($array, 'id', 'name');

        $full_array = array();
        if (!empty($list)) 
            foreach ($list as $id => $name) {
                $item_array = array(
                    'label' => $name,
                    'url' => array('update', 'id' => $id)
                );

                $children = Categories::getAdminMenu($id);
                if (!empty($children)) 
                    $item_array['items'] = $children;
                
                $full_array[] = $item_array;
            }

        return $full_array;
    }
        
        
	/**
	 * @return Array
	 */
    public function getChildrenIds()
    {       
        $ret = array();
        
        if (!empty($this->children)) {
            foreach ($this->children as $child) {
                $ret[] = $child->id;
                
                $ret = array_merge($ret, $child->getChildrenIds());
            }
        }
        
        return $ret;
    }
        
        
	/**
	 * @return Array
	 */
    public function getAllPreoptions()
    {       
        $preoptions = array();
        
        if (!empty($this->preoptions)) 
            $preoptions = array_merge($preoptions, $this->preoptions);
        
        if (!empty($this->parent)) 
            $preoptions = array_merge($preoptions, $this->parent->allPreoptions);
        
        return $preoptions;
    }
        
        
	/**
	 * @return Array
	 */
    public function getAllParameters()
    {       
        $parameters = array();
        
        if (!empty($this->parameters)) 
            $parameters = array_merge($parameters, $this->parameters);
        
        if (!empty($this->parent)) 
            $parameters = array_merge($parameters, $this->parent->allParameters);
        
        return $parameters;
    }

    public function getAllCategory()
    {
        $categories = $this->findAll();
        return $categories;
    }

    private function prepareObjectToArray($objects, $parentIds){
        foreach($objects as $object){
            array_push($parentIds, $object['id']);
        }
        return $parentIds;
    }


    public function getParentIds($id){
        $ids = Categories::model()->findAllByAttributes(['parent_id' => $id]);
        $parentIds = [$id];
        $parentIds = $this->prepareObjectToArray($ids, $parentIds);

        return $parentIds;
    }

    public function getElementOffers($id){
        $parentIds = $this->getParentIds($id);

        $query = 'SELECT *, p.firstname as fn, p.lastname as ln, p.photo as photo, op.filename as filename, o.title as title, o.description as descr, o.id as offer_id, o.owner_id as owner_id FROM categories as c inner join offers as o on c.id = o.category_id 
                  inner join profiles as p on o.owner_id = p.user_id
                  inner join offer_photos as op on op.offer_id = o.id
                  where c.parent_id in ('.implode(",",$parentIds).') and o.status = 1 order by RAND() limit 3';
        $offers = Categories::findAllBySql($query);
        return $offers;
    }

    public function getRandomOffers()
    {
        $query = 'SELECT *, p.firstname as fn, p.lastname as ln, p.photo as photo, op.filename as filename, o.title as title, o.description as descr, o.id as offer_id, o.owner_id as owner_id FROM categories as c inner join offers as o on c.id = o.category_id 
                  inner join profiles as p on o.owner_id = p.user_id
                  inner join offer_photos as op on op.offer_id = o.id
                  where o.status = 1 group by o.id order by RAND() limit 12';
        $offers = Categories::findAllBySql($query);
        return $offers;
    }


}