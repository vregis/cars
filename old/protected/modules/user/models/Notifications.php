<?php

/**
 * This is the model class for table "notifications".
 *
 * The followings are the available columns in table 'notifications':
 * @property integer $id
 * @property integer $type
 * @property string $text
 * @property string $date
 * @property integer $viewed
 */
class Notifications extends CActiveRecord
{
    public $types = array('Общее уведомление', 'Новый платеж', 'Новый заказ');
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Notifications the static model class
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
		return 'notifications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, text, date', 'required'),
			array('type, viewed', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, type, text, date, viewed', 'safe'),
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
			'type' => 'Тип уведомления',
			'text' => 'Текст',
			'date' => 'Дата',
			'viewed' => 'Просмотрено',
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
		$criteria->compare('type',$this->type);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('viewed',$this->viewed);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`date` DESC';
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
	 * Save resources and do preparations.
	 * @return Boolean
	 */
    protected function beforeSave()
    {
        if ($this->isNewRecord)
            $this->date = date('Y-m-d H:i:s');
        
        return parent::beforeSave();
    }
    
    
    public function plural($number, $one, $two, $five) {
        if (($number - $number % 10) % 100 != 10) {
            if ($number % 10 == 1)
                $result = $one;
            elseif ($number % 10 >= 2 && $number % 10 <= 4) 
                $result = $two;
            else 
                $result = $five;
        } else 
            $result = $five;
        
        return $number.' '.$result;        
    }
        
        
	/**
	 * Convert date to string
	 * @return String
	 */
    public function gettimeLeft()
    {
        $full = false;
        $now = new DateTime;
        $ago = new DateTime($this->date);
        $diff = $now->diff($ago);
        $seconds_diff = $now->getTimestamp() - $ago->getTimestamp();


        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $return_value = '';

        if ($seconds_diff <= (1*60+59)) { //less than 1 min 59 sec
            $return_value = 'только что';
        } else if ($seconds_diff <= (59*60+59)) { // up to 59 min 59 sec
            $return_value = $this->plural($diff->i, 'минуту', 'минуты', 'минут').' назад';
        } else if ($seconds_diff <= (1*60*60+59*60+59)) { // up to 1 hour 59 min 59 sec
            $return_value = 'час назад';
        } else if ($seconds_diff <= (23*60*60+59*60+59)) { // up to 23 hours 59 min 59 sec
            $return_value = $this->plural($diff->h, 'час', 'часа', 'часов').' назад';
        } else if ($seconds_diff <= (1*24*60*60+23*60*60+59*60+59)) { // up to 1 day 23 hour 59 min 59 sec
            $return_value = 'день назад';
        } else if ($seconds_diff <= (6*24*60*60+23*60*60+59*60+59)) { // up to 6 days 23 hour 59 min 59 sec
            $return_value = $this->plural($diff->d, 'день', 'дня', 'дней').' назад';
        } else if ($seconds_diff <= (1*7*24*60*60+6*24*60*60+23*60*60+59*60+59)) { // up to 1 week 6 days 23 hour 59 min 59 sec
            $return_value = 'неделю назад';
        } else if ($seconds_diff <= (3*7*24*60*60+6*24*60*60+23*60*60+59*60+59)) { // up to 3 weeks 6 days 23 hour 59 min 59 sec
            $return_value = $this->plural($diff->w, 'неделю', 'недели', 'недель').' назад';
        } else if ($seconds_diff <= (1*4*7*24*60*60+3*7*24*60*60+6*24*60*60+23*60*60+59*60+59)) { // up to 1 month 3 weeks 6 days 23 hour 59 min 59 sec
            $return_value = 'месяц назад';
        } else if ($seconds_diff <= (11*4*7*24*60*60+3*7*24*60*60+6*24*60*60+23*60*60+59*60+59)) { // up to 11 month 3 weeks 6 days 23 hour 59 min 59 sec
            $return_value = $this->plural($diff->m, 'месяц', 'месяца', 'месяцев').' назад';
        } else if ($seconds_diff <= (1*12*4*7*24*60*60+11*4*7*24*60*60+3*7*24*60*60+6*24*60*60+23*60*60+59*60+59)) { // up to 1 year 11 month 3 weeks 6 days 23 hour 59 min 59 sec
            $return_value = 'год назад';
        } else {
            $return_value = $this->plural($diff->y, 'год', 'года', 'лет').' назад';
        }

        return $return_value;
    }
        
        
	/**
	 * Create new notification
	 * @return Boolean
	 */
    public static function getNew($user_id)
    {
        $notifications = Notifications::model()->findAll(array(
            'condition' => '`user_id` = :user_id AND `viewed` = 0',
            'params' => array(':user_id' => $user_id),
            'order' => '`date` DESC',
        ));
        
        return $notifications;
    }
}