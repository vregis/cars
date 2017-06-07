<?php

/**
 * This is the model class for table "offer_addresses".
 *
 * The followings are the available columns in table 'offer_addresses':
 * @property integer $id
 * @property integer $user_id
 * @property integer $country_id
 * @property integer $province_id
 * @property string $address
 * @property integer $is_primary
 */
class UserAddresses extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserAddresses the static model class
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
		return 'user_addresses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, country_id', 'required'),
			array('user_id, province_id, is_primary', 'numerical', 'integerOnly'=>true),
			array('address', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, country_id, province_id, city, address, zip, lat, lng, is_primary', 'safe'),
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
			'offersAddresses' => array(self::HAS_MANY, 'OffersAddresses', 'address_id'),
			'country' => array(self::BELONGS_TO, 'ListCountries', 'country_id'),
			'province' => array(self::BELONGS_TO, 'ListProvinces', 'province_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'Пользователь',
			'country_id' => 'Страна',
			'province_id' => 'Провинция/область',
			'city' => 'Населенный пункт',
			'address' => 'Адрес',
			'zip' => 'Индекс',
			'is_primary' => 'Приоритетный адрес',
			'lat' => 'Широта',
			'lng' => 'Долгота',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('zip',$this->zip);
		$criteria->compare('is_primary',$this->is_primary);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`is_primary` DESC';
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
        if (!empty($this->offersAddresses))
            foreach ($this->offersAddresses as $oa) {
                $oa->delete();
            }
            
        return parent::beforeDelete();
    }
    
    
    
    protected function beforeSave()
    {          
        $map = new EGMap();
        $loop = 0;
        $lat = 0;
        $lng = 0;
        while (empty($lat) && empty($lng) && $loop < 10) {
            $geocoded = new EGMapGeocodedAddress($this->fullAddress);
            $geocoded->geocode($map->getGMapClient());
            $lat = $geocoded->getLat();
            $lng = $geocoded->getLng();
            $loop++;
        }
        $this->lat = $lat;
        $this->lng = $lng;
            
        return parent::beforeSave();
    }
        
        
	/**
	 * Get data formatted for DropDownLists and other
	 * @return Array
	 */
    public function getListData()
    {
        $array = $this->findAll(array());
        return CHtml::listData($array, 'id', 'address');
    }
        
        
	/**
	 * Get full address
	 * @return String
	 */
    public function getFullAddress($shorter = false)
    {
        if (!empty($this->country)) {
            if ($shorter)
                $country = $this->country->code;
            else
                $country = $this->country->name;    
        }
        
        $items = array();
        
        if (!empty($this->address)) $items[] = $this->address;
        if (!empty($this->city)) $items[] = $this->city;
        if (!empty($this->province)) $items[] = $this->province->name;
        if (!empty($country)) $items[] = $country;
        if (!empty($this->zip)) $items[] = $this->zip;
        
        return implode(', ', $items);
    }
}