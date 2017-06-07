<?php

/**
 * This is the model class for table "payments".
 *
 * The followings are the available columns in table 'payments':
 * @property integer $id
 * @property integer $order_id
 * @property integer $payment_type
 * @property double $amount
 * @property string $payer_name
 * @property string $country
 * @property string $transfer_number
 * @property string $release_code
 * @property string $log
 * @property string $date_created
 * @property integer $is_approved
 * @property integer $approved_by
 * @property string $date_approved
 *
 * The followings are the available model relations:
 * @property Orders $order
 * @property PaymentTypes $paymentType
 * @property Users $approvedBy
 */
class Payments extends CActiveRecord
{
    const TYPE_REFILL = 0;
    const TYPE_RESTORE = 1;
    const TYPE_ORDER = 2;
    const TYPE_WITHDRAW = 2;
    
    public $types = array(
        Payments::TYPE_REFILL => 'Пополнение счета', 
        Payments::TYPE_RESTORE => 'Возврат по заказу', 
        Payments::TYPE_ORDER => 'Оплата заказа', 
        Payments::TYPE_WITHDRAW => 'Вывод средств'
    );
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Payments the static model class
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
		return 'payments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payment_type, type, amount', 'required'),
			array('order_id, payment_type, is_approved, approved_by', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('payer_name, country, transfer_number', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, client_id, payment_type, amount, payer_name, country, transfer_number, log, date_created, is_approved, approved_by, date_approved', 'safe'),
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
			'order' => array(self::BELONGS_TO, 'Orders', 'order_id'),
			'client' => array(self::BELONGS_TO, 'User', 'client_id'),
			'paymentType' => array(self::BELONGS_TO, 'PaymentTypes', 'payment_type'),
			'approvedBy' => array(self::BELONGS_TO, 'Users', 'approved_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => Yii::t('app', 'Order #'),
			'client_id' => Yii::t('app', 'Client'),
			'payment_type' => Yii::t('app', 'Payment Type'),
			'type' => Yii::t('app', 'Type'),
			'amount' => Yii::t('app', 'Amount'),
			'payer_name' => Yii::t('app', 'Payer name'),
			'country' => Yii::t('app', 'Payer country'),
			'transfer_number' => Yii::t('app', 'Transfer number'),
			'log' => Yii::t('app', 'Logs'),
			'date_created' => Yii::t('app', 'Date created'),
			'is_approved' => Yii::t('app', 'Is approved'),
			'approved_by' => Yii::t('app', 'Approved by'),
			'date_approved' => Yii::t('app', 'Date approved'),
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
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('payment_type',$this->payment_type);
		$criteria->compare('type',$this->type);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payer_name',$this->payer_name,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('transfer_number',$this->transfer_number,true);
		$criteria->compare('log',$this->log,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('is_approved',$this->is_approved);
		$criteria->compare('approved_by',$this->approved_by);
		$criteria->compare('date_approved',$this->date_approved,true);
                
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

    
    
	public function mySearch($type = NULL)
	{
		$criteria=new CDbCriteria;

        $criteria->with = array('order' => array(
            'condition' => '`order`.`client_id` = :client_id OR `t`.`client_id` = :client_id',
            'params' => array(':client_id' => Yii::app()->user->id),
        ));
        
        if (!empty($type)) {
            $criteria->addInCondition('type', $type);
        }
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`t`.`date_created` DESC';
        //$sort->multiSort = true;

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
        if ($this->is_approved) {
            $this->addError('id', 'Нельзя удалить подтвержденную оплату!');
            
            return false;
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
        
        if ($this->isNewRecord && !empty($this->approved_by)) 
            $this->is_approved = 1;
        
        if ($this->isNewRecord && !empty($this->approved_by) || !$this->isNewRecord && $this->changed('approved_by')) 
            $this->date_approved = date('Y-m-d H:i:s');
        
        if (!empty($this->order_id) && empty($this->client_id))
            $this->client_id = $this->order->client_id;
        
        return parent::beforeSave();
    }
        
        
	/**
	 * @return Boolean
	 */
    protected function afterDelete()
    {            
        if (!empty($this->order)) {
            $this->order->client->updateAccount();
            $this->order->updateStatus();
        }
        
        return parent::afterDelete();
    }
        
        
	/**
	 * @return Boolean
	 */
    protected function afterSave()
    {        
        if (!empty($this->order)) {
            $this->order->client->updateAccount();
            $this->order->updateStatus();
        }
        
        return parent::afterSave();
    }
    
    
    
    public function approve()
    {
        $r = false;
        
        if (empty($this->approved_by)) {
            $this->approved_by = Yii::app()->user->id;
            $r = $this->save();
        }
        
        return $r;
    }
    
    
    
    public function getSign()
    {
        if (in_array($this->type, array(Payments::TYPE_ORDER, Payments::TYPE_WITHDRAW))) $sign = '-';
        else $sign = '';
        
        return $sign;
    }
    
    
    
    public function getSignClass()
    {
        if ($this->sign == '-') $class = 'text-danger';
        else $class = 'text-default';
        
        return $class;
    }
}