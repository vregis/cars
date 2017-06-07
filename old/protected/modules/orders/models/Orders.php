<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $id
 * @property integer $offer_id
 * @property integer $client_id
 * @property string $date_since
 * @property string $date_for
 * @property integer $price_type
 * @property string $date_created
 * @property double $total_cost
 * @property integer $status
 * @property string $log
 *
 * The followings are the available model relations:
 * @property Payments[] $payments
 */
class Orders extends CActiveRecord
{
    const STATUS_STEP = 10;
    
    const STATUS_CANCELED = -10;
    const STATUS_NEW = 0;
    const STATUS_SUBMITTED = 10;
    const STATUS_PAYMENT = 20;
    const STATUS_APPROVED = 30;
    const STATUS_SUCCESSFUL = 40;
    
    public $statuses = array(
        Orders::STATUS_CANCELED => 'Отменен',
        Orders::STATUS_NEW => 'Формируется',
        Orders::STATUS_SUBMITTED => 'Ожидает подтверждения',
        Orders::STATUS_PAYMENT => 'К оплате',
        Orders::STATUS_APPROVED => 'Оплачен',
        Orders::STATUS_SUCCESSFUL => 'Успешно выполнен',
    );
    
    const PRICE_TYPE_HOURLY = 0;
    const PRICE_TYPE_DAILY = 1;
    
    public $prices_types = array(
        Orders::PRICE_TYPE_HOURLY => 'Почасовая оплата', 
        Orders::PRICE_TYPE_DAILY => 'Посуточная оплата'
    );
    
    const DAYS_DECLINE_FREE = 5; //Number of days, until decline is penalty free
    const DAYS_WAIT_CLIENT_RESPONSE = 3;
    
    public $dates_split;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Orders the static model class
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
		return 'orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('offer_id, client_id, date_since, date_for', 'required'),
			array('date_since', 'datesOrder'),
			array('date_since, date_for, offer_id, price_daily, price_hourly, price_type, discount', 'fixed'),
			array('offer_id, client_id, price_type, status', 'numerical', 'integerOnly'=>true),
			array('total_cost', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, offer_id, client_id, date_since, date_for, address_from, address_to, price_daily, price_hourly, price_type, discount, release_code, date_created, date_changed, status, notes, canceled_by, canceled_date, cancel_approved, time_to_prepare, date_for_real, dates_split', 'safe'),
		);
	}
    
    /**
     * check if date_for goes after date_since
     */
    public function datesOrder($attribute,$params)
    {
        $date_since = new DateTime($this->date_since);
        $date_for = new DateTime($this->date_for);

        if ($date_for <= $date_since)
          $this->addError('date_since', 'Порядок приема и сдачи неверный, проверьте даты!');
    }
    
    public function fixed($attribute, $params)
    {
        if ($this->status > Orders::STATUS_PAYMENT && $this->changed($attribute))
            $this->addError($attribute, 'Нельзя изменять параметр «'.$this->getAttributeLabel($attribute).'» для оплаченного заказа!');
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'options' => array(self::MANY_MANY, 'OfferOptions', 'ordered_options(order_id, option_id)', 'order' => '`options`.`order` ASC'),
			'orderedOptions' => array(self::HAS_MANY, 'OrderedOptions', 'order_id'),
			'payments' => array(self::HAS_MANY, 'Payments', 'order_id', 'order' => '`date_created` ASC'),
			'approvedPayments' => array(self::HAS_MANY, 'Payments', 'order_id', 'condition'=>'`is_approved` = 1', 'order' => '`date_created` ASC'),
			'offer' => array(self::BELONGS_TO, 'Offers', 'offer_id'),
			'client' => array(self::BELONGS_TO, 'User', 'client_id'),
			'offerReviews' => array(self::HAS_MANY, 'OfferReviews', 'order_id', 'order' => '`date_created` ASC'),
			'userReviews' => array(self::HAS_MANY, 'UserReviews', 'order_id', 'order' => '`date_created` ASC'),
			'addressFrom' => array(self::BELONGS_TO, 'OffersAddresses', 'address_from'),
			'addressTo' => array(self::BELONGS_TO, 'OffersAddresses', 'address_to'),
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
			'client_id' => Yii::t('app', 'Client'),
			'date_since' => Yii::t('app', 'Date of reception'),
			'date_for' => Yii::t('app', 'Date of return'),
            'time_to_prepare' => Yii::t('app', 'Time to prepare for next order'),
			'price_daily' => Yii::t('app', 'Price per day'),
			'price_hourly' => Yii::t('app', 'Price per hour'),
			'price_type' => Yii::t('app', 'Price type'),
			'address_from' => Yii::t('app', 'Address of reception'),
			'address_to' => Yii::t('app', 'Address of return'),
			'discount' => Yii::t('app', 'Discount, %'),
			'date_created' => Yii::t('app', 'Date created'),
			'total_cost' => Yii::t('app', 'Total cost'),
			'status' => Yii::t('app', 'Status'),
			'log' => Yii::t('app', 'Logs'),
			'notes' => Yii::t('app', 'Notes'),
			'release_code' => Yii::t('app', 'Payment release code (PRC)'),
			'canceled_by' => Yii::t('app', 'Cancel Initiator'),
			'canceled_date' => Yii::t('app', 'Date of Cancel'),
			'cancel_approved' => Yii::t('app', 'Cancel Approved'),
            'dates_split' => Yii::t('app', 'Date Period'),
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
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('date_since',$this->date_since,true);
		$criteria->compare('date_for',$this->date_for,true);
		$criteria->compare('price_type',$this->price_type);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('total_cost',$this->total_cost);
		$criteria->compare('status',$this->status);
		$criteria->compare('log',$this->log,true);
		$criteria->compare('release_code',$this->release_code,true);
                
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
    
    
    
	public function clientSearch($status = Orders::STATUS_NEW)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('client_id', Yii::app()->user->id);
		$criteria->addInCondition('status', $status);
                
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
    
    
    
	public function offerSearch()
	{
		$criteria=new CDbCriteria;

		$criteria->with = array('offer' => array(
            'condition' => '`owner_id` = :owner_id',
            'params' => array(':owner_id' => Yii::app()->user->id),
        ));
		$criteria->addNotInCondition('`t`.status', array(Orders::STATUS_CANCELED, Orders::STATUS_NEW));
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`t`.`date_created` DESC';

        // results per page
        $pages->pageSize=20;
        $pages->applyLimit($criteria);

		return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>$pages,
            'sort'=>$sort,
		));
	}
    
    
    
	public function reviewsSearch($only_with_reviews)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('client_id', Yii::app()->user->id);
		$criteria->addInCondition('status', array(Orders::STATUS_SUCCESSFUL));
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`date_created` DESC';

        // results per page
        $pages->pageSize=20;
        $pages->applyLimit($criteria);
        
        $orders = Orders::model()->findAll($criteria);
        
        if (!empty($orders))
            foreach ($orders as $key => $order) {
                if ($only_with_reviews && empty($order->offerReviews))
                    unset($orders[$key]);
                elseif (!$only_with_reviews && !empty($order->offerReviews))
                    unset($orders[$key]);
            }

        $dataProvider = new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>$pages,
            'sort'=>$sort,
		));
        $dataProvider->setData($orders);
        
		return $dataProvider;
	}

	/**
	 * Return old object without changes
	 * @return Orders old object of this record
	 */
    public function getOld() {
        return $this->findByPk($this->id);
    }

	/**
	 * Check if there are any changes to object
	 * @return Boolean
	 */
    public function changed($field) {
        return (!empty($this->old)) && ($this->$field !== $this->old->$field);
    }



    public function old($field)
    {
        $return = NULL;

        if (!empty($this->old))
            $return = $this->old->$field;

        return $return;
    }
        
        
	/**
	 * Remove resources and related models.
	 * @return Boolean
	 */
    protected function beforeDelete()
    {   
        if (!empty($this->approvedPayments)) {
            $this->addError('id', 'Оплаченный заказ не может быть удален.');
            
            return false;
        }  
        
        if (!empty($this->payments)) 
            foreach ($this->payments as $payment) {
                $payment->delete();
            }
        
        if (!empty($this->orderedOptions)) 
            foreach ($this->orderedOptions as $option) {
                $option->delete();
            }
        
        if (!empty($this->offerReviews)) 
            foreach ($this->offerReviews as $review) {
                $review->delete();
            }
        
        if (!empty($this->userReviews)) 
            foreach ($this->userReviews as $review) {
                $review->delete();
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
            $this->time_to_prepare = $this->offer->time_to_prepare;
            
            //Check prices type
            $date_since = new DateTime($this->date_since);
            $date_for = new DateTime($this->date_for);  
            $diff_obj = $date_for->diff($date_since, true);
            if (($diff_obj->y + $diff_obj->m + $diff_obj->d) > 0)
                $this->price_type = Orders::PRICE_TYPE_DAILY;
            else
                $this->price_type = Orders::PRICE_TYPE_HOURLY;        
        
            //Check if offer is already taken for selected dates
            $blocks = $this->offer->getBlocksArray($this->date_since, $this->date_for);
            if (!empty($blocks)) {
                $this->addError('dates_split', 'Offer is already taken for these dates.');
                return false;
            }
            
            $this->total_cost = $this->calculateCost();
            $this->date_created = date('Y-m-d H:i:s');
            $this->status = Orders::STATUS_NEW;
        } else {
            //Allow step of one status up or down only
            if ($this->changed('status') && (abs($this->old->status - $this->status) > Orders::STATUS_STEP) && ($this->status != Orders::STATUS_CANCELED)) {
                $this->addError('status', 'Переход через несколько статусов запрещен.');
                
                return false;
            }
            
            //Save date of status change
            if ($this->changed('status')) 
                $this->date_changed = date('Y-m-d H:i:s');

            //Restore payment for paid order
            if (
                ($this->status == Orders::STATUS_PAYMENT) && ($this->old->status > Orders::STATUS_PAYMENT)
            ) 
                $this->restorePay();

            //Order canceled
            if ($this->status == Orders::STATUS_CANCELED && $this->old->status > Orders::STATUS_PAYMENT)                 
                $this->cancel();
            
            //Recalculate cost after dates changed
            if ($this->changed('date_since') || $this->changed('date_for') || $this->changed('discount')) 
                $this->recalculateCost(true);
            
            //Generate release code (PRC)
            if ($this->changed('status') && $this->status == Orders::STATUS_APPROVED && empty($this->release_code)) 
                $this->generatePRC();
        }
        
        $dateFor = new DateTime($this->date_for);
        $dateFor->add(new DateInterval('PT'.$this->time_to_prepare.'M'));        
        $this->date_for_real = $dateFor->format('Y-m-d H:i:s');
        
        return parent::beforeSave();
    }
        
        
	/**
	 * Update actual order cost 
	 * @return Boolean
	 */
    public function recalculateCost($new_prices = false) {
        if ($new_prices) {
            $this->price_daily = $this->offer->price_daily;
            $this->price_hourly = $this->offer->price_hourly;
        }
        
        $this->total_cost = $this->calculateCost();
    }
        
        
	/**
	 * Calculate actual order cost
	 * @return Float
	 */
    public function calculateCost() {
        if (empty($this->date_since) || empty($this->date_for))
            return false;
        
        $price_daily = $this->price_daily;
        $price_hourly = $this->price_hourly;
        if (!empty($this->options))
            foreach ($this->options as $option) {
                $price_daily += $option->price_daily;
                $price_hourly += $option->price_hourly;
            }
        
        $cost = 0;
        
        if ($this->price_type == Orders::PRICE_TYPE_DAILY) {
            //Count number of days between dates
            $date_since = new DateTime($this->date_since);
            $date_for = new DateTime($this->date_for);        
            
            $diff_obj = $date_for->diff($date_since, true);
            $period = $diff_obj->days;
            if (($diff_obj->h != 0) || ($diff_obj->i != 0) || ($diff_obj->s != 0))
                $period++;
            
            $cost = $period * $price_daily;
        } else {
            //Count number of hours between dates
            $date_since = strtotime($this->date_since);
            $date_for = strtotime($this->date_for);
            
            $diff_sec = $date_for - $date_since;
            $period = ceil($diff_sec / 3600);  
            
            $cost = $period * $price_hourly;     
        }
        
        $total_cost = $cost * (1 - $this->discount/100);
        
        return $total_cost;
    }
    
    
    
    public function getDaysDifference() {
        $since = new DateTime($this->date_since);
        $for  = new DateTime($this->date_for);
        
        $diff = $since->diff($for);
        
        return $diff->days;
    }
    
    
    
    public function getCleanCost() {
        $cleaned = $this->total_cost / (1 - $this->discount/100);
        
        return round($cleaned, 2);
    }
    
    
    
    public function getItemsList() {
        $result = array();
        
        $result[] = array(
            'NAME' => $this->offer->title,
            'AMOUNT' => $this->total_cost,
            'QTY' => '1',
        );
        
        return $result;
    }

	/**
	 * Pay for current order
	 * @return Boolean
	 */
    public function restorePay($restore_partial = false) {
        $payment = new Payments;
        
        $payment->type = Payments::TYPE_RESTORE;
        $payment->date = date('Y-m-d H:i:s');
        $payment->order_id = $this->id;
        $payment->approved_by = Yii::app()->params['bot']['id'];
        
        if ($restore_partial)
            $payment->amount = $this->total_cost;
        else
            $payment->amount = $this->total_cost * Offers::PREPAYMENT_PARTIAL_VALUE;
        
        return $payment->save();
    }
    
    
    
    public function getStatusClass()
    {
        switch ($this->status) {
            case Orders::STATUS_NEW: $label_class = 'text-muted'; break;
            case Orders::STATUS_SUBMITTED: $label_class = 'text-default'; break;
            case Orders::STATUS_PAYMENT: $label_class = 'text-primary'; break;
            case Orders::STATUS_APPROVED: $label_class = 'text-info'; break;
            case Orders::STATUS_SUCCESSFUL: $label_class = 'text-success'; break;
            case Orders::STATUS_CANCELED: $label_class = 'text-danger'; break;
            default: $label_class = 'text-default'; break;
        }
        
        return $label_class;
    }
    
    
    public static function countMyByStatus($status) {
        return Orders::model()->count(array(
            'condition' => '`client_id` = :client_id AND `status` = :status',
            'params' => array(':client_id' => Yii::app()->user->id, ':status' => $status),
        ));
    }
    
    
    
    public function isPaid()
    {
        $total_paid = 0;
        
        $approvedPayments = Payments::model()->findAll(array(
            'condition' => '`order_id` = :order_id AND `approved_by` IS NOT NULL AND `type` = :order_type',
            'params' => array(':order_id' => $this->id, ':order_type' => Payments::TYPE_ORDER),
        ));
        
        if (!empty($approvedPayments))
            foreach ($approvedPayments as $payment) {
                $total_paid += $payment->amount;
            }
        
        return ($total_paid >= $this->total_cost);
    }
    
    
    
    public function updateStatus()
    {        
        if ($this->status == Orders::STATUS_PAYMENT && $this->isPaid()) {
            $this->status = Orders::STATUS_APPROVED;
            $this->save();
        } elseif ($this->status == Orders::STATUS_APPROVED && !$this->isPaid()) {
            $this->status = Orders::STATUS_PAYMENT;
            $this->save();
        }
    }
    
    
    
    private function generatePRC()
    {        
        $this->release_code = strtoupper(mb_substr(md5(time().'DFgfsdg35,.d-sfd'), 0, 10, 'UTF-8'));
    }
        
        
	/**
	 * Calculate difference in days between today and first day of order
	 * @return Integer
	 */
    private function getDateDiff() {        
        $since = new DateTime($this->date_since);
        $today  = new DateTime();
        
        return $since->diff($today)->days;
    }
        
        
	/**
	 * Cancel current order
	 * @return Boolean
	 */
    private function cancel() {
        $this->canceled_by = Yii::app()->user->id;
        $this->canceled_date = date('Y-m-d H:i:s');
        
        
        if ($this->dateDiff <= Orders::DAYS_DECLINE_FREE) {
            $owner = $this->offer->owner;
            $owner->decline_rating += 1;
            $owner->save();
            
            $client = $this->client;
            $client->decline_rating += 1;
            $client->save();
            
            $this->restorePay(true);
        }
    }
}