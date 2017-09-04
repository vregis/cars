<?php

/**
 * This is the model class for table "currencies".
 *
 * The followings are the available columns in table 'currencies':
 * @property integer $id
 * @property string $name
 * @property string $sign
 * @property integer $position
 * @property double $exchange_rate
 */
class Currencies extends CActiveRecord
{
    public $positions = array('Перед числом', 'После числа');
    
    const ACTUAL = 1;
    const BASE = 0;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Currencies the static model class
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
		return 'currencies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, sign', 'required'),
			array('position', 'numerical', 'integerOnly'=>true),
			array('exchange_rate', 'numerical'),
			array('name, sign', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, full_name, name, sign, position, exchange_rate', 'safe'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'full_name' => Yii::t('app', 'Full name'),
			'name' => Yii::t('app', 'Name'),
			'sign' => Yii::t('app', 'Sign'),
			'position' => Yii::t('app', 'Sign position'),
			'exchange_rate' => Yii::t('app', 'Exchange rate'),
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
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('sign',$this->sign,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('exchange_rate',$this->exchange_rate);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`name` ASC';
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
	 * Get data formatted for DropDownLists and other
	 * @return Array
	 */
    public function getListData()
    {
        $array = $this->findAll(array('order' => '`name` ASC'));
        return CHtml::listData($array, 'id', 'name');
    }
    
    
    
    public static function format($base_amount, $currency_type = Currencies::BASE, $apply_name = true) {
        if ($currency_type == Currencies::BASE) {
            $template = Yii::app()->params['base_currency']['template'];        
            $exchange_rate = Yii::app()->params['base_currency']['rate'];
        } else {
            $template = Yii::app()->params['currency']['template'];        
            $exchange_rate = Yii::app()->params['currency']['rate'];
        }
        
        $cur_amount = round($base_amount * $exchange_rate, 2);        
        
        if ($apply_name)
            $value = str_replace('%num%', $cur_amount, $template);
        else
            $value = $cur_amount;
                
        return str_replace('$', '', $value);
    }
    
    
    
    public function getTemplate() {
        $template = '%num%';
        if (!empty($this->sign))
            $sign = $this->sign;
        else
            $sign = $this->name;
        
        if ($this->position == 0)
            $template = $sign.'&nbsp;'.$template;
        else
            $template = $template.'&nbsp;'.$sign;
        
        return $template;
    }
    
    
    
    public static function apply($currency_id) {
        $currency = Currencies::model()->findByPk($currency_id);
        if (!empty($currency)) {
            Yii::app()->params['currency'] = array(
                'id' => $currency->id,
                'name' => $currency->name,
                'template' => $currency->template,
                'rate' => $currency->exchange_rate
            );
            
            Yii::app()->user->setState('currency', $currency->id); 
            $cookie = new CHttpCookie('currency', $currency->id);
            $cookie->expire = time() + (60*60*24*365); // (1 year)
            Yii::app()->request->cookies['currency'] = $cookie; 
            
            $result = true;
        } else
            $result = false;
        
        return $result;
    }
    
    
    
    public function getFullName() {
        return $this->full_name.',&nbsp;'.$this->name;
    }
}