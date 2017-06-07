<?php

/**
 * This is the model class for table "parameters".
 *
 * The followings are the available columns in table 'parameters':
 * @property integer $id
 * @property string $name
 * @property integer $order
 */
class Parameters extends CActiveRecord
{
    public $types = array('Единственное значение из словаря', 'Числовое значение', 'Общее поле', 'Чекбокс', 'Несколько значений из словаря');
    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Parameters the static model class
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
		return 'parameters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, name, type', 'required'),
			array('order, type, is_required', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, type, is_required, order', 'safe'),
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
			'group' => array(self::BELONGS_TO, 'ParameterGroups', 'group_id'),
			'categories' => array(self::MANY_MANY, 'Categories', 'parameters_categories(parameter_id, category_id)'),
			'parameters_categories' => array(self::HAS_MANY, 'ParametersCategories', 'parameter_id'),
			'offer_values' => array(self::HAS_MANY, 'OffersParameterValues', 'parameter_id'),
			'values' => array(self::HAS_MANY, 'ParameterValues', 'parameter_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'group_id' => Yii::t('app', 'Group'),
			'name' => Yii::t('app', 'Name'),
			'type' => Yii::t('app', 'Values type'),
			'is_required' => Yii::t('app', 'Is required'),
			'order' => Yii::t('app', 'Sorting order'),
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
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('order',$this->order);
        
        $criteria->with = array('group');
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`group`.`order` ASC, `t`.`order` ASC';
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
	 * Remove resources and related models.
	 * @return Boolean
	 */
    protected function beforeDelete()
    {    
        if (!empty($this->parameters_categories))
            foreach ($this->parameters_categories as $pc) {
                $pc->delete();
            }
            
        if (!empty($this->values))
            foreach ($this->values as $value) {
                $value->delete();
            }
            
        if (!empty($this->offer_values))
            foreach ($this->offer_values as $value) {
                $value->delete();
            }
            
        return parent::beforeDelete();
    }
        
        
	/**
	 * Save resources and do preparations.
	 * @return Boolean
	 */
    protected function beforeSave()
    {
        return parent::beforeSave();
    }
        
        
	/**
	 * Get data formatted for DropDownLists and other
	 * @return Array
	 */
    public function getListData()
    {
        $array = $this->findAll(array(
            'with' => array('group'),
            'order' => '`group`.`order` ASC, `t`.`order` ASC',
        ));
        return CHtml::listData($array, 'id', 'name', function($data) {return $data->group->name;});
    }
        
        
	/**
	 * Get data formatted for DropDownLists and other
	 * @return Array
	 */
    public function getValuesData()
    {
        $array = $this->values;
        return CHtml::listData($array, 'id', function($data) {return Yii::t('parameters', $data->value);});
    }
        
        
	/**
	 * Get data formatted for DropDownLists and other
	 * @return Array
	 */
    public function getOfferValue($offer_id)
    {
        $value = OffersParameterValues::model()->find(array(
            'condition' => '`parameter_id` = :parameter_id AND `offer_id` = :offer_id',
            'params' => array(':parameter_id' => $this->id, ':offer_id' => $offer_id),
        ));
        
        if (!empty($value))
            return Yii::t('parameters', $value->parameter_value);
        else
            return '';
    }
        
        
	/**
	 * Group parameters by group_id
	 * @return Array
	 */
    public static function groupList($parameters)
    {
        $groups = array();
        
        if (!empty($parameters))
            foreach ($parameters as $parameter) {
                if (!empty($groups[$parameter->group_id]))
                    $groups[$parameter->group_id][] = $parameter;
                else
                    $groups[$parameter->group_id] = array($parameter);
            }
        
        return $groups;
    }
}