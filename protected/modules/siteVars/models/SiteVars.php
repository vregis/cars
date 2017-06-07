<?php

/**
 * This is the model class for table "mail_messages".
 *
 * The followings are the available columns in table 'mail_messages':
 * @property integer $id
 * @property integer $topic_id
 * @property string $text
 * @property integer $user_from
 * @property integer $user_to
 * @property string $date
 *
 * The followings are the available model relations:
 * @property MailTopics $topic
 * @property Users $userFrom
 * @property Users $userTo
 */
class SiteVars extends CActiveRecord
{
    public $types = array('Длинный текст', 'Короткий текст', 'Чекбокс', 'Файл');
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MailMessages the static model class
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
		return 'site_vars';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                    array('name, wysiwyg_on, field_type', 'required'),
                    array('value, description', 'safe'),
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
			'name' => Yii::t('app', 'Name'),
			'value' => Yii::t('app', 'Parameter value'),
			'description' => Yii::t('app', 'Description'),
			'wysiwyg_on' => Yii::t('app', 'Enable visual editor'),
			'field_type' => Yii::t('app', 'Var type'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name);

		return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false,
		));
	}

    
    
	public function siteSearch($text)
	{
        $criteria=new CDbCriteria;

        $criteria->compare('name',$text,true,'OR');
        $criteria->compare('value',$text,true,'OR');

        $sort = new CSort;                
        $sort->defaultOrder = '`name` ASC';                 
        $sort->multiSort = false;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => false,                
            'sort'=>$sort,
        ));
	}
    
        
    /*
     * Return value for SiteVar by name
     * @return String SiteVar value
     */
    public static function v($name) {
        $return = false;
        $var = SiteVars::model()->find(array('condition' => '`name` = :name', 'params' => array(':name' => $name)));

        if (!empty($var)) {
            if ($var->field_type == 3)
                $return = Yii::app()->request->hostInfo.'/resources/vars/'.$var->value;
            elseif ($var->field_type == 2)
                $return = (boolean) $var->value;
            else            
                $return = $var->value;
        } 
        
        return $return;
    }
        
        
	/**
	 * Save resources and do preparations.
	 * @return Boolean
	 */
    protected function beforeSave()
    {
        return parent::beforeSave();
    }
        
        
	/**
	 * Delete resources.
	 * @return Boolean
	 */
    protected function afterDelete()
    {
        if ($this->field_type == 3)
            unlink(dirname(__FILE__).'/../../../../resources/vars/'.$this->value);
        
        return parent::afterDelete();
    }
}