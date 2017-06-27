<?php

/**
 * This is the model class for table "offers".
 *
 * The followings are the available columns in table 'offers':
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $description
 * @property string $rental_information
 * @property string $video_link
 * @property integer $year
 * @property double $price_daily
 * @property double $price_hourly
 * @property integer $owner_id
 * @property string $date_created
 * @property integer $status
 * @property integer $type
 * @property double $rating
 * @property integer $views
 *
 * The followings are the available model relations:
 * @property OfferComments[] $offerComments
 * @property OfferDocuments[] $offerDocuments
 * @property OfferPhotos[] $offerPhotoses
 * @property OfferReviews[] $offerReviews
 * @property Categories $category
 * @property Users $owner
 * @property ListOfferTypes $type0
 * @property ParameterValuesOffers[] $parameterValuesOffers
 */
class Offers extends CActiveRecord
{
    const STATUS_PASSIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_ARCHIVED = 2;
    
    public $statuses = array(
        Offers::STATUS_PASSIVE => 'Пассивный', 
        Offers::STATUS_ACTIVE => 'Активный', 
        Offers::STATUS_ARCHIVED => 'Архивирован', 
    );
    
    public $prepare_time_list = array(
        0 => 'No time', 
        15 => '15 Minutes', 
        30 => '30 Minutes', 
        45 => '45 Minutes', 
        60 => 'One hour'
    );
    public $lp=0;
    public $hp=0;
    const PREPAYMENT_PARTIAL_VALUE = 0.2; // for 20%
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Offers the static model class
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
		return 'offers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, title, description, owner_id, age_from, age_to', 'required'),
			array('category_id, year, owner_id, status, type, views,age_from, age_to', 'numerical', 'integerOnly'=>true),
			array('price_daily, price_hourly, rating', 'numerical'),
			array('title', 'length', 'max'=>500),
			array('video_link', 'length', 'max'=>255),
            /*array('paypal_id', 'email'),*/
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, phone, category_id, title, description, rental_information, video_link, year, price_daily, price_hourly, owner_id, date_created, status, type, rating, views, is_approved, time_to_prepare, is_promo', 'safe'),
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
			'addresses' => array(self::MANY_MANY, 'UserAddresses', 'offers_addresses(offer_id, address_id)', 'order' => '`addresses`.`is_primary` DESC, `addresses`.`id` ASC'),
			'offersAddresses' => array(self::HAS_MANY, 'OffersAddresses', 'offer_id'),
			'primaryPhoto' => array(self::HAS_ONE, 'OfferPhotos', 'offer_id', 'order' => '`order` ASC'),
			'photos' => array(self::HAS_MANY, 'OfferPhotos', 'offer_id', 'order' => '`order` ASC'),
			'category' => array(self::BELONGS_TO, 'Categories', 'category_id'),
			'faq' => array(self::HAS_MANY, 'OfferFaq', 'offer_id', 'order' => '`order` ASC'),
			'blocks' => array(self::HAS_MANY, 'OfferBlocks', 'offer_id'),
			//'options' => array(self::HAS_MANY, 'OfferOptions', 'offer_id', 'order' => '`order` ASC'),
            'options' => array(self::HAS_MANY, 'OfferOptions', 'offer_id', 'on'=>'`options`.`main_option`=1','order' => '`options`.`order` ASC'),
			'publicOptions' => array(self::HAS_MANY, 'OfferOptions', 'offer_id', 'on'=>'`publicOptions`.`main_option`=1', 'order' => '`order` ASC', 'condition' => '`visible` = 1'),
			'parameters' => array(self::HAS_MANY, 'OffersParameterValues', 'offer_id', 'order' => '`parameter`.`order` ASC', 'with' => array('parameter')),
			'reviews' => array(self::HAS_MANY, 'OfferReviews', 'offer_id', 'order' => '`date_created` DESC'),
			'comments' => array(self::HAS_MANY, 'OfferComments', 'offer_id'),
			'topComments' => array(self::HAS_MANY, 'OfferComments', 'offer_id', 'order' => '`date_created` ASC', 'condition' => '`parent_id` IS NULL'),
			'owner' => array(self::BELONGS_TO, 'User', 'owner_id'),
			'documents' => array(self::HAS_MANY, 'OfferDocuments', 'offer_id'),
			'favourites' => array(self::HAS_MANY, 'UserFavourites', 'offer_id'),
			'orders' => array(self::HAS_MANY, 'Orders', 'offer_id', 'order' => '`date_created` DESC'),
			'finishedOrders' => array(self::HAS_MANY, 'Orders', 'offer_id', 'condition' => '`status` = 3', 'order' => '`date_created` DESC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => Yii::t('app', 'Category'),
			'title' => Yii::t('app', 'Title'),
			'description' => Yii::t('app', 'Description'),
			'rental_information' => Yii::t('app', 'Rental information'),
			'video_link' => Yii::t('app', 'Link to video'),
			'year' => Yii::t('app', 'Year'),
			'price_daily' => Yii::t('app', 'Price per day'),
			'price_hourly' => Yii::t('app', 'Price per hour'),
			'owner_id' => Yii::t('app', 'Owner'),
			'date_created' => Yii::t('app', 'Date created'),
			'status' => Yii::t('app', 'Status'),
			'type' => Yii::t('app', 'Offer type'),
			'rating' => Yii::t('app', 'Rating'),
			'views' => Yii::t('app', 'Views'),
			'is_approved' => Yii::t('app', 'Approved'),
            'time_to_prepare' => Yii::t('app', 'Time to prepare for next order'),
            'is_promo' => Yii::t('app', 'Promoted to Home page'),
            'age_from' => Yii::t('app', 'Возраст от'),
            'age_to' => Yii::t('app', 'до'),
            'paypal_id' => Yii::t('app', 'PayPal ID'),
            'phone' => Yii::t('app', 'Номер телефона'),
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('rental_information',$this->rental_information,true);
		$criteria->compare('video_link',$this->video_link,true);
		$criteria->compare('year',$this->year);
		$criteria->compare('price_daily',$this->price_daily);
		$criteria->compare('price_hourly',$this->price_hourly);
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('views',$this->views);
		$criteria->compare('is_approved',$this->is_approved);
        $criteria->compare('paypal_id',$this->paypal_id);
        $criteria->compare('phone',$this->phone);

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
    
    
    
	public function frontendSearch()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('owner_id', Yii::app()->user->id);
		$criteria->addInCondition('status', array(Offers::STATUS_ACTIVE));
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`date_created` DESC';

        // results per page
        $pages->pageSize=20;
        $pages->applyLimit($criteria);

		return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>$pages,
            'sort'=>$sort,
		));
	}
    
    
    
	public function archivedSearch()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('owner_id', Yii::app()->user->id);
		$criteria->addInCondition('status', array(Offers::STATUS_PASSIVE, Offers::STATUS_ARCHIVED));
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`date_created` DESC';

        // results per page
        $pages->pageSize=20;
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
            'sitemap'=>array('select'=>'id', 'condition'=>'status = 1'),
        );
    }
        
        
	/**
	 * Remove resources and related models.
	 * @return Boolean
	 */
    protected function beforeDelete()
    {        
        if (!empty($this->orders)) {
            $this->addError('id', 'Заказанные предложения не могут быть удалены.');
            
            return false;
        }
        
        if (!empty($this->offersAddresses))
            foreach ($this->offersAddresses as $oa) {
                $oa->delete();
            }
        
        if (!empty($this->blocks))
            foreach ($this->blocks as $b) {
                $b->delete();
            }
            
        if (!empty($this->photos))
            foreach ($this->photos as $photo) {
                $photo->delete();
            }
            
        if (!empty($this->faq))
            foreach ($this->faq as $faq) {
                $faq->delete();
            }
            
        if (!empty($this->options))
            foreach ($this->options as $option) {
                $option->delete();
            }
              
        if (!empty($this->parameters))
            foreach ($this->parameters as $pv) {
                $pv->delete();
            }
            
        if (!empty($this->reviews))
            foreach ($this->reviews as $review) {
                $review->delete();
            }
            
        if (!empty($this->comments))
            foreach ($this->comments as $comment) {
                $comment->delete();
            }
            
        if (!empty($this->favourites))
            foreach ($this->favourites as $favourite) {
                $favourite->delete();
            }
            
        if (!empty($this->documents))
            foreach ($this->documents as $document) {
                $document->delete();
            }
            
        return parent::beforeDelete();
    }
        
        
	/**
	 * Save resources and do preparations.
	 * @return Boolean
	 */
    protected function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->date_created = date('Y-m-d H:i:s');
        }
        
        if (stristr($this->video_link, 'watch?v='))
            $this->video_link = str_replace('watch?v=', 'v/', $this->video_link);
        
        
        return parent::beforeSave();
    }
        
        
	/**
	 * @return Boolean
	 */
    protected function afterSave()
    {

        if ($this->isNewRecord) {
            //Add preset options
            $preoptions = $this->category->allPreoptions;
            if (!empty($preoptions))
                foreach ($preoptions as $preoption) {
                    $option = new OfferOptions;
                    $option->offer_id = $this->id;
                    $option->title = $preoption->title;
                    $option->description = $preoption->description;
                    $option->visible = 0;
                    $option->save();
                }
        }
        
        return parent::afterSave();
    }
    
    
	
	public static function getData() {
        $array = Offers::model()->findAll(array(
            'condition' => '`status` = 1',
            'order' => '`date_created` DESC',
        ));
        
        return CHtml::listData($array, 'id', function($data) {return $data->title;});
	}
    
    
	
	public function getAddressesList() {        
        return CHtml::listData($this->offersAddresses, 'id', function($data) {return $data->address->fullAddress;});
	}
    
    
	
	public function updateRating() {
        $summary_rating = 0;
        $total_count = 0;
        
        if (!empty($this->reviews))
            foreach ($this->reviews as $review) {
                $summary_rating += $review->rating;
                $total_count++;
            }
        else 
            $total_count = 1;
        
        $this->rating = round($summary_rating / $total_count, 2);
        
        return true;
	}
    
    
	
	public function getSimilarOffers() {
        $criteria = new CDbCriteria();
        
        $criteria->compare('`t`.id', '<>'.$this->id);
        $criteria->compare('`t`.category_id', $this->category_id);
        
        
        $criteria->with = array('addresses');
        $criteria->together = true;
        if (!empty($this->addresses)) {            
            foreach ($this->addresses as $address) {
                $criteria->addBetweenCondition('`addresses`.lat', $address->lat - FormSearch::LATLNG_DIFF, $address->lat + FormSearch::LATLNG_DIFF);
                $criteria->addBetweenCondition('`addresses`.lng', $address->lng - FormSearch::LATLNG_DIFF, $address->lng + FormSearch::LATLNG_DIFF);            
            }
        }
        
        $criteria->limit = 4;
        
        $offers = $this->findAll($criteria);
        
        return $offers;
	}
    
    
	
	public function getInfoFillLevel() {
        $results = array(
            'percent' => 0,
            'skills' => array(),
        );
        
        if (!empty($this->addresses)) $results['percent'] += 15; else 
            $results['skills'][] = array('value' => 15, 'description' => Yii::t('app', 'add addresses'));
        
        if (!empty($this->photos)) $results['percent'] += 15; else 
            $results['skills'][] = array('value' => 15, 'description' => Yii::t('app', 'add photos'));
        
        if (!empty($this->faq)) $results['percent'] += 5; else 
            $results['skills'][] = array('value' => 5, 'description' => Yii::t('app', 'add FAQ info'));
        
        if (!empty($this->options)) $results['percent'] += 10; else 
            $results['skills'][] = array('value' => 10, 'description' => Yii::t('app', 'add options'));
        
        if (!empty($this->parameters)) $results['percent'] += 10; else 
            $results['skills'][] = array('value' => 10, 'description' => Yii::t('app', 'add parameters'));
        
        if (!empty($this->documents)) $results['percent'] += 15; else 
            $results['skills'][] = array('value' => 15, 'description' => Yii::t('app', 'add documents'));
        
        if (
            !empty($this->description) && !empty($this->rental_information) && !empty($this->video_link) && 
            !empty($this->year) && !empty($this->price_daily) && !empty($this->price_hourly)
        ) $results['percent'] += 30; else 
            $results['skills'][] = array('value' => 30, 'description' => Yii::t('app', 'add offer description'));
        
        return $results;
	}
    
    
	
	public function getRange() {
        if ($this->price_hourly < 50)
            $range = 0;
        elseif ($this->price_hourly >= 50 && $this->price_hourly < 100)
            $range = 1;
        elseif ($this->price_hourly >= 100 && $this->price_hourly < 200)
            $range = 2;
        elseif ($this->price_hourly >= 200)
            $range = 3;
        
        return $range;
	}
    
    
	
	public function isBlocked($date_since, $date_for) {
        $blocks = $this->getBlocksArray($date_since, $date_for);
        
        $check = false;
        if (count($blocks) == 1) {
            $block = $blocks[0];
            
            $block_since = new DateTime($block[0]);
            $block_for = new DateTime($block[1]);
            $origin_since = new DateTime($date_since);
            $origin_for = new DateTime($date_for);
            
            $check = ($block_since <= $origin_since && $block_for >= $origin_for);                
        }
        
        return $check;
	}
    
    
	
	public function getBlocksArray($date_since, $date_for) {
        $blocks = $this->formBlocksArray($date_since, $date_for);
        usort($blocks, array('Offers','sortBlocksArray'));
        
        return $this->splitBlocksArray($blocks);
	}
    
    
    
    private function formBlocksArray($date_since, $date_for) {
        $ret = array();
        
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('date_since', $date_since, $date_for, 'OR');
        $criteria->addBetweenCondition('date_for', $date_since, $date_for, 'OR');
        $criteria->compare('offer_id', $this->id);
        
        $blocked = OfferBlocks::model()->findAll($criteria);
        if (!empty($blocked))
            foreach ($blocked as $item) {
                $ret[] = array($item->date_since, $item->date_for);
            }
            
        $criteria->addInCondition('status', array(Orders::STATUS_PAYMENT, Orders::STATUS_APPROVED));
        $orders = Orders::model()->findAll($criteria);
        if (!empty($orders))
            foreach ($orders as $item) {
                $ret[] = array($item->date_since, $item->date_for);
            }
            
        return $ret;
    }
    
    
    
    private function sortBlocksArray($a, $b) {
        $dateA = new DateTime($a[0]);
        $dateB = new DateTime($b[0]);
        
        if ($dateA == $dateB) {
            return 0;
        }
        
        return ($dateA < $dateB) ? -1 : 1;
    }
    
    
    
    private function splitBlocksArray($blocks) {
        if (!empty($blocks))
            foreach ($blocks as $key => $block) {
                if (!empty($blocks[$key+1])) {
                    $next_block = $blocks[$key+1];
                    $dateA = new DateTime($block[1]);
                    $dateB = new DateTime($next_block[0]);
                    
                    if ($dateA >= $dateB) {
                        $blocks[$key+1][0] = $block[0];
                        unset($blocks[$key]);
                    }
                }
            }
        
        return $blocks;
    }

    /**
     * @param $categoryId
     * @return array|mixed|null|static[]
     */
    public function getOffersFromCategoryId($categoryId)
    {
        return $this->findAll('category_id = :categoryId', [':categoryId' => $categoryId]);
    }

    public function getRandomOffersForMainPage()
    {

    }

}