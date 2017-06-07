<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANED=-1;
	
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		
		return ((Yii::app()->getModule('user')->isAdmin())?array(
			array('username', 'length', 'max'=>128, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 128 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			//array('username', 'match', 'pattern' => '/^[A-Za-z0-9+_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANED)),
			array('email, createtime, lastvisit, superuser, status', 'required'),
			array('createtime, lastvisit, superuser, status, is_approved', 'numerical', 'integerOnly'=>true),
		):((Yii::app()->user->id==$this->id)?array(
			array('email', 'required'),
			array('username', 'length', 'max'=>128, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 128 characters).")),
			array('email', 'email'),
			array('superuser', 'in', 'range'=>array(0,1,2)),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			//array('username', 'match', 'pattern' => '/^[A-Za-z0-9+_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
		):array()));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		$relations = array(
			'addresses'=>array(self::HAS_MANY, 'UserAddresses', 'user_id', 'order' => '`is_primary` DESC'),
			'approvedDocuments'=>array(self::HAS_MANY, 'OfferDocuments', 'approved_by'),
			'offers'=>array(self::HAS_MANY, 'Offers', 'owner_id', 'order' => '`date_created` DESC',),
			'canceledOffers'=>array(self::HAS_MANY, 'Offers', 'canceled_by', 'order' => '`date_created` DESC',),
			'activeOffers'=>array(self::HAS_MANY, 'Offers', 'owner_id', 'order' => '`date_created` DESC', 'condition' => '`status` = 1'),
			'favourites'=>array(self::HAS_MANY, 'UserFavourites', 'user_id', 'order' => '`date_added` DESC'),
			'favouriteOffers'=>array(self::MANY_MANY, 'Offers', 'user_favourites(user_id, offer_id)'),
			'offerComments'=>array(self::HAS_MANY, 'OfferComments', 'author_id', 'order' => '`date_created` DESC',),
			'reviews'=>array(self::HAS_MANY, 'UserReviews', 'user_id', 'order' => '`date_created` DESC'),
			'reviewMarks'=>array(self::HAS_MANY, 'UserReviewsMarks', 'author_id', 'order' => '`date_created` DESC'),
			'orders'=>array(self::HAS_MANY, 'Orders', 'client_id', 'order' => '`date_created` DESC',),
			'approvedPayments'=>array(self::HAS_MANY, 'Payments', 'approved_by', 'order' => '`date_approved` DESC',),
			'withdraws'=>array(self::HAS_MANY, 'Withdraws', 'user_id', 'order' => '`date_created` DESC',),
			'approvedWithdraws'=>array(self::HAS_MANY, 'Withdraws', 'approved_by', 'order' => '`date_created` DESC',),
			'articles'=>array(self::HAS_MANY, 'Articles', 'author_id', 'order' => '`date_created` DESC',),
			'notifications'=>array(self::HAS_MANY, 'Notifications', 'user_id', 'order' => '`date` DESC'),
			'messagesSent'=>array(self::HAS_MANY, 'PrivateMessages', 'sender_id', 'order' => '`date_created` DESC'),
			'messagesReceived'=>array(self::HAS_MANY, 'PrivateMessages', 'recepient_id', 'order' => '`date_created` DESC'),
			'profile'=>array(self::HAS_ONE, 'Profile', 'user_id'),
			'documents'=>array(self::HAS_MANY, 'UserDocuments', 'user_id', 'order' => '`date_uploaded` DESC'),
			'approvedMyDocuments'=>array(self::HAS_MANY, 'UserDocuments', 'user_id', 'condition' => '`is_approved` = 1'),
			'approvedUserDocuments'=>array(self::HAS_MANY, 'UserDocuments', 'approved_by'),            
		);
		if (isset(Yii::app()->getModule('user')->relations)) $relations = array_merge($relations,Yii::app()->getModule('user')->relations);
		return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>UserModule::t("Username"),
			'password'=>UserModule::t("Password"),
			'verifyPassword'=>UserModule::t("Retype Password"),
			'legacy'=>UserModule::t("Agree the terms of use and cookies policy."),
			'email'=>UserModule::t("E-mail"),
			'verifyCode'=>UserModule::t("Verification Code"),
			'id' => UserModule::t("Id"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'lastvisit' => UserModule::t("Last visit"),
			'superuser' => UserModule::t("Superuser"),
			'status' => UserModule::t("Status"),
			'account' => UserModule::t('Сумма на счету'),
			'parameter_1' => UserModule::t('Параметр 1'),
			'parameter_2' => UserModule::t('Параметр 2'),
			'parameter_3' => UserModule::t('Параметр 3'),
			'rating' => UserModule::t('Рейтинг'),
			'is_approved' => UserModule::t('Подтвержденный аккаунт'),
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactvie'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANED,
            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'client'=>array(
                'condition'=>'superuser=0',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, activkey, createtime, lastvisit, superuser, status',
            ),
        );
    }
	
	public function defaultScope()
    {
        return array(
            'select' => 'id, username, email, createtime, lastvisit, superuser, status, social_identity, account, available_account, rating, parameter_1, parameter_2, parameter_3, is_approved, first_complete',
        );
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('Посетитель'),
				'1' => UserModule::t('Администратор'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('username',$this->username);

        $sort = new CSort;
        $sort->defaultOrder = '`superuser` DESC, `id` DESC';
        $sort->multiSort = false;

        $count=$this->count($criteria);
        $pages=new CPagination($count);

        // results per page
        $pages->pageSize=Yii::app()->params['paginator_results_per_page'];
        $pages->applyLimit($criteria);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>$pages,
            'sort'=>$sort,
        ));
	}
        
        
    protected function beforeDelete()
    {
        if (!empty($this->profile)) {
            $p = $this->profile;
            $p->delete();
        }
        
        if (!empty($this->addresses)) {
            foreach ($this->addresses as $address) {
                $address->delete();
            }
        }
        
        if (!empty($this->approvedDocuments)) {
            foreach ($this->approvedDocuments as $doc) {
                $doc->is_approved = 0;
                $doc->approved_by = NULL;
                $doc->date_approved = NULL;
                $doc->save();
            }
        }
        
        if (!empty($this->offers)) {
            foreach ($this->offers as $offer) {
                $offer->delete();
            }
        }
        
        if (!empty($this->favourites)) {
            foreach ($this->favourites as $favourite) {
                $favourite->delete();
            }
        }
        
        if (!empty($this->offerComments)) {
            foreach ($this->offerComments as $offerComment) {
                $offerComment->delete();
            }
        }
        
        if (!empty($this->reviews)) {
            foreach ($this->reviews as $review) {
                $review->delete();
            }
        }
        
        if (!empty($this->reviewMarks)) {
            foreach ($this->reviewMarks as $reviewMark) {
                $reviewMark->delete();
            }
        }
        
        if (!empty($this->orders)) {
            foreach ($this->orders as $order) {
                $order->delete();
            }
        }
        
        if (!empty($this->approvedPayments)) {
            foreach ($this->approvedPayments as $approvedPayment) {
                $approvedPayment->is_approved = 0;
                $approvedPayment->approved_by = NULL;
                $approvedPayment->date_approved = NULL;
                $approvedPayment->save();
            }
        }
        
        if (!empty($this->withdraws)) {
            foreach ($this->withdraws as $withdraw) {
                $withdraw->delete();
            }
        }
        
        if (!empty($this->approvedWithdraws)) {
            foreach ($this->approvedWithdraws as $approvedWithdraw) {
                $approvedWithdraw->is_approved = 0;
                $approvedWithdraw->approved_by = NULL;
                $approvedWithdraw->date_approved = NULL;
                $approvedWithdraw->save();
            }
        }
        
        if (!empty($this->articles)) {
            foreach ($this->articles as $article) {
                $article->save();
            }
        }
        
        if (!empty($this->notifications)) {
            foreach ($this->notifications as $notification) {
                $notification->delete();
            }
        }
        
        if (!empty($this->messagesSent)) {
            foreach ($this->messagesSent as $messageSent) {
                $messageSent->delete();
            }
        }
        
        if (!empty($this->messagesReceived)) {
            foreach ($this->messagesReceived as $messageReceived) {
                $messageReceived->delete();
            }
        }
        
        if (!empty($this->documents)) {
            foreach ($this->documents as $document) {
                $document->delete();
            }
        }
        
        if (!empty($this->approvedUserDocuments)) {
            foreach ($this->approvedUserDocuments as $approvedUserDocument) {
                $approvedUserDocument->is_approved = 0;
                $approvedUserDocument->approved_by = NULL;
                $approvedUserDocument->date_approved = NULL;
                $approvedUserDocument->delete();
            }
        }

        return parent::beforeDelete();
    }
        
        
    protected function beforeSave()
    {
        $this->username = $this->email;
        
        
        //Check if account is approved
        $social = stristr($this->social_identity, 'FB') || stristr($this->social_identity, 'GP');
        $documents = count($this->approvedUserDocuments);
        if ($social && $documents) $this->is_approved = 1; else $this->is_approved = 0;

        return parent::beforeSave();
    }
    
    
	
	public function updateRating() {
        $summary_rating_1 = 0;
        $summary_rating_2 = 0;
        $summary_rating_3 = 0;
        $total_count = 0;
        
        if (!empty($this->reviews))
            foreach ($this->reviews as $review) {
                $summary_rating_1 += $review->parameter_1;
                $summary_rating_2 += $review->parameter_2;
                $summary_rating_3 += $review->parameter_3;
                $total_count++;
            }
        else 
            $total_count = 1;
        
        $this->parameter_1 = round($summary_rating_1 / $total_count, 2);
        $this->parameter_2 = round($summary_rating_2 / $total_count, 2);
        $this->parameter_3 = round($summary_rating_3 / $total_count, 2);
        
        $this->rating = round((($this->parameter_1 + $this->parameter_2 + $this->parameter_3) / 3), 2);
        
        return true;
	}
        
    
        
    public function updateAccount()
    {
        $payments = Payments::model()->findAll(array(
            'condition' => '`order`.`client_id` = :client_id AND `t`.`approved_by` IS NOT NULL',
            'params' => array(':client_id' => $this->id),
            'with' => array('order'),
        ));
        
        $account = 0;
        if (!empty($payments))
            foreach ($payments as $payment) {
                if ($payment->sign == '-')
                    $account -= $payment->amount;
                else
                    $account += $payment->amount;
            }
            
        $this->account = $account;        
        return $this->save();
    }
        
    
        
    public function updateAvailableAccount()
    {
        $payments = Payments::model()->findAll(array(
            'condition' => '`order`.`client_id` = :client_id AND `t`.`approved_by` IS NOT NULL',
            'params' => array(':client_id' => $this->id),
            'with' => array('order'),
        ));
        
        $account = 0;
        if (!empty($payments))
            foreach ($payments as $payment) {
                if ($payment->sign == '-')
                    $account -= $payment->amount;
                else
                    $account += $payment->amount;
            }
            
        $this->account = $account;        
        return $this->save();
    }
	
    
    
    
	public function getProfileUrl() {
        $url = Yii::app()->createAbsoluteUrl('/user/profile/view', array('id'=>$this->id));
        
        return $url;
	}
	
    
    
    
	public function isApprovedClient() {
        $orders = Orders::model()->find(array(
            'condition' => '`offer`.owner_id = :owner_id AND `t`.`client_id` = :client_id AND `t`.`status` >= :status_approved',
            'params' => array(':owner_id' => $this->id, ':client_id' => Yii::app()->user->id, ':status_approved' => Orders::STATUS_APPROVED),
            'with' => array('offer'),
        ));
        
        return !empty($orders);
	}
    
    
    
    
    public function generatePassword() {
        $password = substr(md5(time().'d~5*3Fk02,D/'), 0, 8);
        $this->password = md5($password);
        return $password;
    }
    
    
    
    
    public function sendPassword($password) {        
        $title = 'Thank you for Registration at GetUpWay.com';

        $message = 'Hello,<br /><br />you\'ve been registered at GetUpWay.com.<br /><br />';

        $message .= 'Your password: <strong>'.$password.'</strong><br />';
        $message .= 'Please, change it as soon as possible';

        $mail = new MailForms();
        return $mail->sendNotification($title, $message, $this->email);
    }
}