<?php

/**
 * This is the model class for table "parameter_values_products".
 *
 * The followings are the available columns in table 'parameter_values_products':
 * @property integer $id
 * @property integer $parameter_value
 * @property integer $offer_id
 */
class OffersParameterValues extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OffersParameterValues the static model class
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
		return 'offers_parameter_values';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parameter_id, offer_id', 'required'),
			array('parameter_id, offer_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parameter_id, parameter_value, offer_id', 'safe'),
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
			'parameter' => array(self::BELONGS_TO, 'Parameters', 'parameter_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parameter_value' => Yii::t('app', 'Parameter value'),
			'offer_id' => Yii::t('app', 'Offer'),
			'parameter_id' => Yii::t('app', 'Parameter'),
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
		$criteria->compare('parameter_value',$this->parameter_value);
		$criteria->compare('offer_id',$this->offer_id);
		$criteria->compare('parameter_id',$this->parameter_id);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`id` ASC';
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
        if ($this->parameter->is_required && empty($this->parameter_value)) {
            $this->addError('parameter_value', 'This parameter is required.');
            
            return false;
        }
        return parent::beforeSave();
    }
    
    
    
    public function getValue()
    {
        $value = '';
        
        if ($this->parameter->type == 0) {
            $value_obj = ParameterValues::model()->findByPk($this->parameter_value);
            if (!empty($value_obj))
                $value = Yii::t('parameters', $value_obj->value);
            else
                $value = '';
        } elseif ($this->parameter->type == 1 || $this->parameter->type == 2) {
            $value = Yii::t('parameters', $this->parameter_value);
        } elseif ($this->parameter->type == 3 && $this->parameter_value == 1) {
            $value = Yii::t('parameters', $this->parameter->name);
        } else {
            $id_list = explode(', ', $this->parameter_value);
            $values_arr = array();
            
            if (!empty($id_list))
                foreach ($id_list as $value_id) {
                    $value_obj = ParameterValues::model()->findByPk($value_id);
                    if (!empty($value_obj))
                        $values_arr[] = Yii::t('parameters', $value_obj->value);
                }
                
            if (!empty($values_arr))
                $value = implode(', ', $values_arr);
            else
                $value = '';
        }
        
        return $value;
    }
}