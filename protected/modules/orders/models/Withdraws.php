<?php

/**
 * This is the model class for table "withdraws".
 *
 * The followings are the available columns in table 'withdraws':
 * @property integer $id
 * @property integer $user_id
 * @property integer $payment_type
 * @property double $amount
 * @property string $payer_name
 * @property string $country
 * @property string $transfer_number
 * @property string $log
 * @property string $date_created
 * @property integer $is_approved
 * @property integer $approved_by
 * @property string $date_approved
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property PaymentTypes $paymentType
 * @property Users $approvedBy
 */
class Withdraws extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Withdraws the static model class
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
		return 'withdraws';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, amount', 'required'),
			array('user_id, payment_type, is_approved, approved_by', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('payer_name, country, transfer_number', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, payment_type, amount, payer_name, country, transfer_number, log, date_created, is_approved, approved_by, date_approved', 'safe'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'paymentType' => array(self::BELONGS_TO, 'PaymentTypes', 'payment_type'),
			'approvedBy' => array(self::BELONGS_TO, 'User', 'approved_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => Yii::t('app', 'Client'),
			'payment_type' => Yii::t('app', 'Payment Type'),
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('payment_type',$this->payment_type);
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
        
    
        
	/**
	 * Check if specified field changed
	 * @return Boolean
	 */
    public function changed($field)
    {
        $origin = $this->findByPk($this->id);

        if (!empty($origin))
            $return = ($this->$field !== $origin->$field);
        else
            $return = false;
        
        return $return;
    }



    public function old($field)
    {
        $origin = $this->findByPk($this->id);

        if (!empty($origin))
            $return = $origin->$field;
        else
            $return = NULL;

        return $return;
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
        if ($this->isNewRecord) 
            $this->date_created = date('Y-m-d H:i:s');
        
        return parent::beforeSave();
    }
        
        
	/**
	 * Update related models
	 * @return Boolean
	 */
    protected function afterDelete()
    {             
        return parent::afterDelete();
    }
}