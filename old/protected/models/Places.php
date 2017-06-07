<?php

/**
 * This is the model class for table "places".
 *
 * The followings are the available columns in table 'places':
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property integer $country_id
 * @property integer $province_id
 * @property string $address
 */
class Places extends CActiveRecord
{
    public $types = array(
        'accounting' => 'fa-building-o',
        'airport' => 'fa-building-o',
        'amusement_park' => 'fa-building-o',
        'aquarium' => 'fa-building-o',
        'art_gallery' => 'fa-building-o',
        'atm' => 'fa-building-o',
        'bakery' => 'fa-building-o',
        'bank' => 'fa-building-o',
        'bar' => 'fa-building-o',
        'beauty_salon' => 'fa-building-o',
        'bicycle_store' => 'fa-building-o',
        'book_store' => 'fa-building-o',
        'bowling_alley' => 'fa-building-o',
        'bus_station' => 'fa-building-o',
        'cafe' => 'fa-building-o',
        'campground' => 'fa-building-o',
        'car_dealer' => 'fa-building-o',
        'car_rental' => 'fa-building-o',
        'car_repair' => 'fa-building-o',
        'car_wash' => 'fa-building-o',
        'casino' => 'fa-building-o',
        'cemetery' => 'fa-building-o',
        'church' => 'fa-building-o',
        'city_hall' => 'fa-building-o',
        'clothing_store' => 'fa-building-o',
        'convenience_store' => 'fa-building-o',
        'courthouse' => 'fa-building-o',
        'dentist' => 'fa-building-o',
        'department_store' => 'fa-building-o',
        'doctor' => 'fa-building-o',
        'electrician' => 'fa-building-o',
        'electronics_store' => 'fa-building-o',
        'embassy' => 'fa-building-o',
        'establishment' => 'fa-building-o',
        'finance' => 'fa-building-o',
        'fire_station' => 'fa-building-o',
        'florist' => 'fa-building-o',
        'food' => 'fa-building-o',
        'funeral_home' => 'fa-building-o',
        'furniture_store' => 'fa-building-o',
        'gas_station' => 'fa-building-o',
        'general_contractor' => 'fa-building-o',
        'grocery_or_supermarket' => 'fa-building-o',
        'gym' => 'fa-building-o',
        'hair_care' => 'fa-building-o',
        'hardware_store' => 'fa-building-o',
        'health' => 'fa-building-o',
        'hindu_temple' => 'fa-building-o',
        'home_goods_store' => 'fa-building-o',
        'hospital' => 'fa-building-o',
        'insurance_agency' => 'fa-building-o',
        'jewelry_store' => 'fa-building-o',
        'laundry' => 'fa-building-o',
        'lawyer' => 'fa-building-o',
        'library' => 'fa-building-o',
        'liquor_store' => 'fa-building-o',
        'local_government_office' => 'fa-building-o',
        'locksmith' => 'fa-building-o',
        'lodging' => 'fa-building-o',
        'meal_delivery' => 'fa-building-o',
        'meal_takeaway' => 'fa-building-o',
        'mosque' => 'fa-building-o',
        'movie_rental' => 'fa-building-o',
        'movie_theater' => 'fa-building-o',
        'moving_company' => 'fa-building-o',
        'museum' => 'fa-building-o',
        'night_club' => 'fa-building-o',
        'painter' => 'fa-building-o',
        'park' => 'fa-building-o',
        'parking' => 'fa-building-o',
        'pet_store' => 'fa-building-o',
        'pharmacy' => 'fa-building-o',
        'physiotherapist' => 'fa-building-o',
        'place_of_worship' => 'fa-building-o',
        'plumber' => 'fa-building-o',
        'police' => 'fa-building-o',
        'post_office' => 'fa-building-o',
        'real_estate_agency' => 'fa-building-o',
        'restaurant' => 'fa-building-o',
        'roofing_contractor' => 'fa-building-o',
        'rv_park' => 'fa-building-o',
        'school' => 'fa-building-o',
        'shoe_store' => 'fa-building-o',
        'shopping_mall' => 'fa-building-o',
        'spa' => 'fa-building-o',
        'stadium' => 'fa-building-o',
        'storage' => 'fa-building-o',
        'store' => 'fa-building-o',
        'subway_station' => 'fa-building-o',
        'synagogue' => 'fa-building-o',
        'taxi_stand' => 'fa-building-o',
        'train_station' => 'fa-building-o',
        'travel_agency' => 'fa-building-o',
        'university' => 'fa-building-o',
        'veterinary_care' => 'fa-building-o',
        'zoo' => 'fa-building-o',
        'administrative_area_level_1' => 'fa-building-o',
        'administrative_area_level_2' => 'fa-building-o',
        'administrative_area_level_3' => 'fa-building-o',
        'administrative_area_level_4' => 'fa-building-o',
        'administrative_area_level_5' => 'fa-building-o',
        'colloquial_area' => 'fa-building-o',
        'country' => 'fa-building-o',
        'floor' => 'fa-building-o',
        'geocode' => 'fa-building-o',
        'intersection' => 'fa-building-o',
        'locality' => 'fa-building-o',
        'natural_feature' => 'fa-building-o',
        'neighborhood' => 'fa-building-o',
        'political' => 'fa-building-o',
        'point_of_interest' => 'fa-building-o',
        'post_box' => 'fa-building-o',
        'postal_code' => 'fa-building-o',
        'postal_code_prefix' => 'fa-building-o',
        'postal_town' => 'fa-building-o',
        'premise' => 'fa-building-o',
        'room' => 'fa-building-o',
        'route' => 'fa-building-o',
        'street_address' => 'fa-building-o',
        'street_number' => 'fa-building-o',
        'sublocality' => 'fa-building-o',
        'sublocality_level_1' => 'fa-building-o',
        'sublocality_level_2' => 'fa-building-o',
        'sublocality_level_3' => 'fa-building-o',
        'sublocality_level_4' => 'fa-building-o',
        'sublocality_level_5' => 'fa-building-o',
        'subpremise' => 'fa-building-o',
        'transit_station' => 'fa-building-o',        
    );
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Places the static model class
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
		return 'places';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, name', 'required'),
			array('type, province_id', 'numerical', 'integerOnly'=>true),
			array('name, address', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, name, province_id, address', 'safe'),
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
			'province' => array(self::BELONGS_TO, 'Provinces', 'province_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => Yii::t('app', 'POI type'),
			'name' => Yii::t('app', 'Name'),
			'province_id' => Yii::t('app', 'Province/region'),
			'address' => Yii::t('app', 'Address'),
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
		$criteria->compare('type',$this->type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('address',$this->address,true);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`type` ASC, `name` ASC';
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
            'sitemap'=>array('select'=>'id'),
        );
    }
        
        
	/**
	 * Remove resources and related models.
	 * @return Boolean
	 */
    protected function beforeDelete()
    {            
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
}