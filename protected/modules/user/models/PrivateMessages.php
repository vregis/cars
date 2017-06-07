<?php

/**
 * This is the model class for table "private_messages".
 *
 * The followings are the available columns in table 'private_messages':
 * @property integer $id
 * @property integer $recepient_id
 * @property integer $sender_id
 * @property string $text
 * @property string $date_created
 * @property integer $status
 */
class PrivateMessages extends CActiveRecord
{
    const IM_STATUS_VISIBLE = 0;
    const IM_STATUS_HIDDEN_R = 1;
    const IM_STATUS_HIDDEN_S = 2;
    const IM_STATUS_HIDDEN_BOTH = 3;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PrivateMessages the static model class
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
		return 'private_messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recepient_id, sender_id, text', 'required'),
			array('recepient_id, sender_id, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, recepient_id, sender_id, text, date_created, is_seen, status', 'safe'),
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
			'recepient' => array(self::BELONGS_TO, 'User', 'recepient_id'),
			'sender' => array(self::BELONGS_TO, 'User', 'sender_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'recepient_id' => 'Получатель',
			'sender_id' => 'Отправитель',
			'text' => 'Текст',
			'date_created' => 'Дата создания',
			'is_seen' => 'Просмотрено',
			'status' => 'Статус',
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
		$criteria->compare('recepient_id',$this->recepient_id);
		$criteria->compare('sender_id',$this->sender_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('status',$this->status);
                
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
	 * Save resources and do preparations.
	 * @return Boolean
	 */
    protected function beforeSave()
    {
        if ($this->isNewRecord)
            $this->date_created = date('Y-m-d H:i:s');
        
        return parent::beforeSave();
    }
	
    
    
    
	public static function getMyContacts() {
        
        $recepient_condition = '`recepient_id` = :recipient_id AND status IN ('.PrivateMessages::IM_STATUS_VISIBLE.', '.PrivateMessages::IM_STATUS_HIDDEN_S.')';
        $sender_condition = '`sender_id` = :sender_id AND status IN ('.PrivateMessages::IM_STATUS_VISIBLE.', '.PrivateMessages::IM_STATUS_HIDDEN_R.')';
        
        $messages = PrivateMessages::model()->findAll(array(
            'select' => '`recepient_id`, `sender_id`',
            'condition' => $recepient_condition.' OR '.$sender_condition,
            'params' => array(':recipient_id' => Yii::app()->user->id, ':sender_id' => Yii::app()->user->id),
            'group' => '`recepient_id`, `sender_id`',
        ));
        
        $contacts = array();
        if (!empty($messages))
            foreach ($messages as $message) {
                $contact = (($message->recepient_id == Yii::app()->user->id)?($message->sender):($message->recepient));
                if (!in_array($contact, $contacts))
                    $contacts[] = $contact;
            }
        
        $contacts_menu = array();
        if (!empty($contacts))
            foreach ($contacts as $contact) {
                $label = '<i class="fa fa-user fa-fw"></i> '.$contact->profile->name;
                $new_messages = PrivateMessages::countNew($contact->id);
                if (!empty($new_messages))
                    $label .= ' <sup class="text-danger pm-label" data-id="'.$contact->id.'">(+'.$new_messages.')</sup>';
            
                $contacts_menu[] = array(
                    'label' => $label,
                    'url' => array('/user/privateMessages/dialog', 'id' => $contact->id)
                );
            }
        
        return $contacts_menu;
	}    
    
    
    
    public function setStatus($status_type)
    {
        if ($status_type == PrivateMessages::IM_STATUS_HIDDEN_S) {
            if ($this->status == PrivateMessages::IM_STATUS_VISIBLE)
                $this->status = PrivateMessages::IM_STATUS_HIDDEN_S;
            elseif ($this->status == PrivateMessages::IM_STATUS_HIDDEN_R)
                $this->status = PrivateMessages::IM_STATUS_HIDDEN_BOTH;
        } elseif ($status_type == PrivateMessages::IM_STATUS_HIDDEN_R) {
            if ($this->status == PrivateMessages::IM_STATUS_VISIBLE)
                $this->status = PrivateMessages::IM_STATUS_HIDDEN_R;
            elseif ($this->status == PrivateMessages::IM_STATUS_HIDDEN_S)
                $this->status = PrivateMessages::IM_STATUS_HIDDEN_BOTH;
        }
        
        return $this->save();
    }
    
    
    
    public function getStatus($status_type)
    {        
        return ($this->status & $status_type);
    }
    
    
    
    public static function countNew($sender_id = NULL)
    {        
        $count = 0;
        
        if (empty($sender_id)) {
            $count = PrivateMessages::model()->count(array(
                'condition' => '`recepient_id` = :user_id AND `is_seen` = 0',
                'params' => array(':user_id' => Yii::app()->user->id),
            ));
        } else {
            $count = PrivateMessages::model()->count(array(
                'condition' => '`recepient_id` = :user_id AND `sender_id` = :sender_id AND `is_seen` = 0',
                'params' => array(':user_id' => Yii::app()->user->id, ':sender_id' => $sender_id),
            ));
        }
        
        return $count;
    }
    
    
    
    public static function getDialog($id)
    {        
        $criteria=new CDbCriteria;
        // echo '###############################################id: '.$id;
        $recepient_condition = '`recepient_id` = :recipient_me AND `sender_id` = :sender_co AND status IN ('.PrivateMessages::IM_STATUS_VISIBLE.', '.PrivateMessages::IM_STATUS_HIDDEN_S.')';
        $sender_condition = '`recepient_id` = :recipient_co AND `sender_id` = :sender_me AND status IN ('.PrivateMessages::IM_STATUS_VISIBLE.', '.PrivateMessages::IM_STATUS_HIDDEN_R.')';

		$criteria->condition = $recepient_condition.' OR '.$sender_condition;
		$criteria->params = array(
            ':recipient_me' => Yii::app()->user->id, ':sender_me' => Yii::app()->user->id,
            ':recipient_co' => $id, ':sender_co' => $id,
        );
		$criteria->order = '`date_created` ASC';
        
        return PrivateMessages::model()->findAll($criteria);
    }
}