<?php

/**
 * This is the model class for table "list_provinces".
 *
 * The followings are the available columns in table 'list_provinces':
 * @property integer $id
 * @property integer $country_id
 * @property string $name
 * @property string $code
 *
 * The followings are the available model relations:
 * @property ListCountries $country
 */
class ListProvinces extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ListProvinces the static model class
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
		return 'list_provinces';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id, name', 'required'),
			array('country_id', 'numerical', 'integerOnly'=>true),
			array('name, code', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, country_id, name, code', 'safe'),
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
			'country' => array(self::BELONGS_TO, 'ListCountries', 'country_id'),
			'places' => array(self::HAS_MANY, 'Places', 'province_id', 'order' => '`type` ASC, `name` ASC'),
			'userAddresses' => array(self::HAS_MANY, 'UserAddresses', 'province_id'),
			'users' => array(self::HAS_MANY, 'User', 'province_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'country_id' => Yii::t('app', 'Country'),
			'name' => Yii::t('app', 'Name'),
			'code' => Yii::t('app', 'Code'),
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
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`name` ASC';
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
        if (!empty($this->userAddresses)) {
            $this->addError('id', 'Нельзя удалить провинцию, с которой соотнесен адрес клиента.');
            
            return false;
        }
        
        if (!empty($this->users)) {
            $this->addError('id', 'Нельзя удалить провинцию, с которой соотнесена локация клиента.');
            
            return false;
        }
        
        if (!empty($this->places)) {
            $this->addError('id', 'Нельзя удалить провинцию, с которой соотнесены POI.');
            
            return false;
        }
        
        return parent::beforeDelete();
    }
    
    
    
    public function getFullName() {
        $name = $this->name;
        
        if (!empty($this->country))
            $name .= ', '.$this->country->name;
        
        return $name;
    }
        
    
        
	/**
	 * Get data formatted for DropDownLists and other
	 * @return Array
	 */
    public function getListData()
    {
        $array = $this->findAll(array());
        return CHtml::listData($array, 'id', function($data) {return $data->fullName;}, function($data) {return $data->country->name;});
    }
}