<?php

/**
 * This is the model class for table "subscribers".
 *
 * The followings are the available columns in table 'subscribers':
 * @property integer $id
 * @property string $email
 * @property string $date_created
 */
class Subscribers extends CActiveRecord
{
    public $accepted;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Subscribers the static model class
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
		return 'subscribers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, date_created', 'required'),
			array('email', 'email'),
			array('email', 'unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, email, date_created', 'safe'),
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
			'email' => 'E-mail',
			'name' => Yii::t('app', 'Name'),
			'date_created' => Yii::t('app', 'Date subscribed'),
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
		$criteria->compare('email',$this->email,true);
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
	 * Format data for export
	 * @return Array
	 */
    public function export($type)
    {
        $subscribers = $this->findAll(array('order' => '`date_created` DESC'));
        
        $list = CHtml::listData($subscribers, 'id', 'email');
                
        $data = '';
        switch ($type) {
            case 'csv': $data = "\"email\"\r\n".implode("\r\n", array_values($list))."\r\n"; break;
            case 'array': $data = array_values($list); break;
        }
        
        return $data;
    }
        
        
	/**
	 * Send mails for all subscribers
	 * @return Boolean
	 */
    public function sendMails($title, $text)
    {
        $subscribers = $this->export('array');
        
        $report = array();
        if (!empty($subscribers))
            foreach ($subscribers as $client) {
                $mail = new MailForms();
                $result = $mail->sendInformation($title, $text, $client);
                
                $report[$client] = $result;
            }
        
        return $report;
    }
        
        
	/**
	 * Send mails for all subscribers
	 * @return Boolean
	 */
    public function sendTest($title, $text)
    {
        $report = array();
        
        $mail = new MailForms();
        $result = $mail->sendInformation($title, $text, Yii::app()->params['adminEmail']);

        $report[Yii::app()->params['adminEmail']] = $result;
        
        return $report;
    }
}