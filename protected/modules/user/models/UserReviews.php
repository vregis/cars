<?php

/**
 * This is the model class for table "user_reviews".
 *
 * The followings are the available columns in table 'user_reviews':
 * @property integer $id
 * @property integer $user_id
 * @property integer $order_id
 * @property string $text
 * @property integer $parameter_1
 * @property integer $parameter_2
 * @property integer $parameter_3
 * @property string $date_created
 */
class UserReviews extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserReviews the static model class
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
		return 'user_reviews';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, order_id, text', 'required'),
			array('user_id, order_id, parameter_1, parameter_2, parameter_3', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, order_id, text, parameter_1, parameter_2, parameter_3, date_created', 'safe'),
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
			'order' => array(self::BELONGS_TO, 'Orders', 'order_id'),
			'marks' => array(self::HAS_MANY, 'UserReviewsMarks', 'review_id', 'order' => '`date_created` ASC'),
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
			'order_id' => 'Номер заказа',
			'text' => 'Текст отзыва',
			'parameter_1' => 'Параметр 1',
			'parameter_2' => 'Параметр 2',
			'parameter_3' => 'Параметр 3',
			'date_created' => 'Дата добавления',
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
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('parameter_1',$this->parameter_1);
		$criteria->compare('parameter_2',$this->parameter_2);
		$criteria->compare('parameter_3',$this->parameter_3);
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
	 * Update user model and relative
	 * @return Boolean
	 */
    protected function afterDelete()
    {       
        $user = $this->user;
        $user->updateRating();
        $user->save();
            
        return parent::afterDelete();
    }
        
        
	/**
	 * Update user model and relative
	 * @return Boolean
	 */
    protected function afterSave()
    {
        $user = $this->user;
        $user->updateRating();
        $user->save();
            
        return parent::afterSave();
    }
}