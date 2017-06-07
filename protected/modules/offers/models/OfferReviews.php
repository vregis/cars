<?php

/**
 * This is the model class for table "offer_reviews".
 *
 * The followings are the available columns in table 'offer_reviews':
 * @property integer $id
 * @property integer $offer_id
 * @property integer $order_id
 * @property string $text
 * @property string $response
 * @property integer $rating
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property Offers $offer
 * @property Users $author
 */
class OfferReviews extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OfferReviews the static model class
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
		return 'offer_reviews';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('offer_id, order_id, text', 'required'),
			array('offer_id, order_id, rating', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, offer_id, order_id, text, response, rating, date_created', 'safe'),
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
			'order' => array(self::BELONGS_TO, 'Orders', 'order_id'),
			'photos' => array(self::HAS_MANY, 'OfferReviewPhotos', 'review_id', 'order' => '`order` ASC'),
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
			'order_id' => Yii::t('app', 'Order #'),
			'text' => Yii::t('app', 'Client review'),
			'response' => Yii::t('app', 'Owner response'),
			'rating' => Yii::t('app', 'Rating'),
			'date_created' => Yii::t('app', 'Date created'),
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
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('response',$this->response,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('date_created',$this->date_created,true);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`date_created` DESC';
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
        if (!empty($this->photos)) 
            foreach ($this->photos as $photo) {
                $photo->delete();
            }
            
        return parent::beforeDelete();
    }
        
        
	/**
	 * Save resources and do preparations.
	 * @return Boolean
	 */
    protected function beforeSave()
    {
        if ($this->isNewRecord)
            $this->date_created = date('Y-m-d H:i:s');
        
        return parent::beforeSave();
    }
        
        
	/**
	 * Update offer model and relative
	 * @return Boolean
	 */
    protected function afterDelete()
    {       
        $offer = $this->offer;
        $offer->updateRating();
        $offer->save();
            
        return parent::afterDelete();
    }
        
        
	/**
	 * Update offer model and relative
	 * @return Boolean
	 */
    protected function afterSave()
    {
        $offer = $this->offer;
        $offer->updateRating();
        $offer->save();
            
        return parent::afterSave();
    }
}