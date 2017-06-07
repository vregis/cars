<?php

/**
 * This is the model class for table "offer_addresses".
 *
 * The followings are the available columns in table 'offer_addresses':
 * @property integer $id
 * @property integer $offer_id
 * @property integer $country_id
 * @property integer $province_id
 * @property string $address
 * @property integer $is_primary
 */
class OffersAddresses extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OffersAddresses the static model class
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
		return 'offers_addresses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('offer_id, address_id', 'required'),
			array('offer_id, address_id, is_primary', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, offer_id, address_id, is_primary', 'safe'),
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
			'offer' => array(self::BELONGS_TO, 'Offers', 'offer_id'),
			'address' => array(self::BELONGS_TO, 'UserAddresses', 'address_id'),
			'ordersFrom' => array(self::HAS_MANY, 'Orders', 'address_from'),
			'ordersTo' => array(self::HAS_MANY, 'Orders', 'address_to'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'offer_id' => Yii::t('app', 'Offer'),
			'address_id' => Yii::t('app', 'Address'),
			'is_primary' => Yii::t('app', 'Prior address'),
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
		$criteria->compare('offer_id',$this->offer_id);
		$criteria->compare('address_id',$this->address_id);
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
        if (!empty($this->ordersFrom) || !empty($this->ordersTo)) {
            $this->addError('id', 'С этим адресом связаны один или несколько заказов.');
            
            return false;
        }
        
        return parent::beforeDelete();
    }
}