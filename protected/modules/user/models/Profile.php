<?php

class Profile extends UActiveRecord
{
	/**
	 * The followings are the available columns in table 'profiles':
	 * @var integer $user_id
	 * @var boolean $regMode
	 */
	public $regMode = false;
        
    public $userUsername = '';
    public $userEmail = '';         
    public $userSuperuser = '';      
	
	private $_model;
	private $_modelReg;

    public $preview_sizes = array(
        'photo' => array(
            array('width' => 48, 'height' => 48, 'pre' => '48'),
            array('width' => 200, 'height' => 200, 'pre' => '200'),
            array('width' => 600, 'pre' => '600'),
        ),
        'photo2' => array(
            array('width' => 200, 'height' => 200, 'pre' => '200'),
            array('width' => 600, 'pre' => '600'),
        ),
        'photo3' => array(
            array('width' => 200, 'height' => 200, 'pre' => '200'),
            array('width' => 600, 'pre' => '600'),
        )
    );
    
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
		return Yii::app()->getModule('user')->tableProfiles;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$required = array();
		$numerical = array();		
		$rules = array();
		
		$model=$this->getFields();
		
		foreach ($model as $field) {
			$field_rule = array();
			if ($field->required==ProfileField::REQUIRED_YES_NOT_SHOW_REG||$field->required==ProfileField::REQUIRED_YES_SHOW_REG)
				array_push($required,$field->varname);
			if ($field->field_type=='FLOAT'||$field->field_type=='INTEGER')
				array_push($numerical,$field->varname);
			if ($field->field_type=='VARCHAR'||$field->field_type=='TEXT') {
				$field_rule = array($field->varname, 'length', 'max'=>$field->field_size, 'min' => $field->field_size_min);
				if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
				array_push($rules,$field_rule);
			}
			if ($field->other_validator) {
				if (strpos($field->other_validator,'{')===0) {
					$validator = (array)CJavaScript::jsonDecode($field->other_validator);
					foreach ($validator as $name=>$val) {
						$field_rule = array($field->varname, $name);
						$field_rule = array_merge($field_rule,(array)$validator[$name]);
						if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
						array_push($rules,$field_rule);
					}
				} else {
					$field_rule = array($field->varname, $field->other_validator);
					if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
					array_push($rules,$field_rule);
				}
			} elseif ($field->field_type=='DATE') {
				$field_rule = array($field->varname, 'type', 'type' => 'date', 'dateFormat' => 'yyyy-mm-dd', 'allowEmpty'=>true);
				if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
				array_push($rules,$field_rule);
			}
			if ($field->match) {
				$field_rule = array($field->varname, 'match', 'pattern' => $field->match);
				if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
				array_push($rules,$field_rule);
			}
			if ($field->range) {
				$field_rule = array($field->varname, 'in', 'range' => self::rangeRules($field->range));
				if ($field->error_message) $field_rule['message'] = UserModule::t($field->error_message);
				array_push($rules,$field_rule);
			}
		}
		//array_push($rules,array(implode(',',$required), 'required'));
		//($rules,array(implode(',',$numerical), 'numerical', 'integerOnly'=>true));
		array_push($rules,array('user_id, firstname, lastname, notes, userUsername, userEmail, userSuperuser, country_id, city, alter_phone, gender, birthday, is_company, languages', 'safe'));
		array_push($rules,array('photo,photo2,photo3', 'unsafe'));
		array_push($rules,array('firstname', 'required'));

		return $rules;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			'user'=>array(self::HAS_ONE, 'User', 'id'),
			'country'=>array(self::BELONGS_TO, 'ListCountries', 'country_id'),
		);
		if (isset(Yii::app()->getModule('user')->profileRelations)) $relations = array_merge($relations,Yii::app()->getModule('user')->profileRelations);
		return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = array(
			'user_id' => UserModule::t('ID'),
			'country' => UserModule::t('Country'),
		);
		$model=$this->getFields();
		
		foreach ($model as $field)
			$labels[$field->varname] = ((Yii::app()->getModule('user')->fieldsMessage)?UserModule::t($field->title,array(),Yii::app()->getModule('user')->fieldsMessage):UserModule::t($field->title));
			
		return $labels;
	}
	
	private function rangeRules($str) {
		$rules = explode(';',$str);
		for ($i=0;$i<count($rules);$i++)
			$rules[$i] = current(explode("==",$rules[$i]));
		return $rules;
	}
	
	static public function range($str,$fieldValue=NULL) {
		$rules = explode(';',$str);
		$array = array();
		for ($i=0;$i<count($rules);$i++) {
			$item = explode("==",$rules[$i]);
			if (isset($item[0])) $array[$item[0]] = ((isset($item[1]))?$item[1]:$item[0]);
		}
		if (isset($fieldValue)) 
			if (isset($array[$fieldValue])) return $array[$fieldValue]; else return '';
		else
			return $array;
	}
	
	public function widgetAttributes() {
		$data = array();
		$model=$this->getFields();
		
		foreach ($model as $field) {
			if ($field->widget) $data[$field->varname]=$field->widget;
		}
		return $data;
	}
	
	public function widgetParams($fieldName) {
		$data = array();
		$model=$this->getFields();
		
		foreach ($model as $field) {
			if ($field->widget) $data[$field->varname]=$field->widgetparams;
		}
		return $data[$fieldName];
	}
	
	public function getFields() {
		if ($this->regMode) {
			if (!$this->_modelReg)
				$this->_modelReg = ProfileField::model()->forRegistration()->findAll();            
			return $this->_modelReg;
		} else {
			if (!$this->_model)
				$this->_model=ProfileField::model()->forOwner()->findAll();
			return $this->_model;
		}
	}

	/**
	 * Return old object without changes
	 * @return Orders old object of this record
	 */
    public function getOld() {
        return $this->findByPk($this->user_id);
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
        $this->removeImages();
            
        return parent::beforeDelete();
    }
        
        
	/**
	 * Save resources and do preparations.
	 * @return Boolean
	 */
    protected function beforeSave()
    {     
        if (!$this->isNewRecord) {
            $check = false;
            
            if ($this->changed('public_phone') && empty($this->public_phone)) {
                $this->addError('public_phone', 'Not allowed to delete phone.');
                $check = true;
            }
            
            if ($this->changed('alter_phone') && empty($this->alter_phone)) {
                $this->addError('alter_phone', 'Not allowed to delete alter phone.');
                $check = true;
            }
            
            if ($check) return false;
        }
        
        $this->prepareImages();
        
        return parent::beforeSave();
    }
    

    protected function afterSave()
    {        
        $this->saveImages();

        return parent::afterSave();
    }
    
    
    public function getSourcesPath() {
        return dirname(__FILE__).'/../../../../resources/users/';
    }

    
    public function removeImages($only_field = NULL)
    {        
        if (!empty($this->preview_sizes)) 
            foreach ($this->preview_sizes as $field => $previews) {
                if (empty($only_field) || $only_field == $field) {
                    foreach ($previews as $preview) {
                        if (is_file($this->sourcesPath.$preview['pre'].'_'.$this->$field))
                            unlink($this->sourcesPath.$preview['pre'].'_'.$this->$field);
                    }
                    
                    if (is_file($this->sourcesPath.$this->$field))
                        unlink($this->sourcesPath.$this->$field);
                }
            }
        
        return true;
    }

    
    public function prepareImages()
    {            
        if (!empty($this->preview_sizes)) 
            foreach ($this->preview_sizes as $field => $previews) {
                if (empty($this->instance))
                    $$field = CUploadedFile::getInstance($this, $field);
                else
                    $$field = $this->instance;

                if (isset($$field)) {
                    $this->removeImages($field);

                    $uname = date('YmdHis').'_'.substr(md5(uniqid(rand(), true)), 0, rand(7, 13)).'.'.$$field->extensionName;
                    $this->$field = $uname;
                }
            }
        
        return true;
    }

    
    public function saveImages()
    {    
        if (!empty($this->preview_sizes)) 
            foreach ($this->preview_sizes as $field => $previews) {
                if (empty($this->instance))
                    $$field = CUploadedFile::getInstance($this, $field);
                else
                    $$field = $this->instance;

                if (isset($$field)) {
                    //save original
                    $$field->saveAs($this->sourcesPath.$this->$field);
                    
                    //generate previews
                    $this->savePreviews($field);
                }
            }    
        
        return true;
    }

    
    public function savePreviews($field)
    {    
        if (!empty($this->preview_sizes[$field])) 
            foreach ($this->preview_sizes[$field] as $preview) {
                $image_open = Yii::app()->image->load($this->sourcesPath.$this->$field);

                if (isset($preview['width']) && isset($preview['height'])) {
                    if ($image_open->width / $image_open->height > $preview['width'] / $preview['height']) $dim = Image::HEIGHT; else $dim = Image::WIDTH;
                    $image_open->resize($preview['width'], $preview['height'], $dim)->crop($preview['width'], $preview['height']);
                } elseif (isset($preview['width'])) {
                    $image_open->resize($preview['width'], $preview['width'], Image::WIDTH);
                } elseif (isset($preview['height'])) {
                    $image_open->resize($preview['height'], $preview['height'], Image::HEIGHT);
                }

                $image_open->save($this->sourcesPath.$preview['pre'].'_'.$this->$field);
            }    
        
        return true;
    }
    
    
	
	public function getShortName() {
        $ret = $this->firstname.' '.mb_substr($this->lastname, 0, 1, 'UTF-8').'.';
        return trim($ret);
	}
    
    
	
	public function getName() {
        $ret = ucwords($this->lastname).' '.ucwords($this->firstname);
        return trim($ret);
	}
    
    
	
	public function getFullName() {
        $ret = $this->lastname.' '.$this->firstname;

        if (!empty($this->code))
            $ret .= ', код: '.$this->code;

        if (!empty($this->organization))
            $ret .= ' ('.$this->organization.')';

        return trim($ret);
	}
    
    
	
	public function getUniqueName() {
        $ret = $this->getFullName();

        $ret .= ', [ID: '.$this->user_id.']';

        return trim($ret);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function adminSearch()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->with = array('user');
		$criteria->compare('`user`.`username`',$this->userUsername,true);
		$criteria->compare('`user`.`email`',$this->userEmail,true);
		//$criteria->compare('`user`.`superuser`','1');
                
        $sort = new CSort;
        $sort->defaultOrder = '`lastname` ASC, `firstname` ASC';

        $count=$this->count($criteria);
        $pages=new CPagination($count);

        // results per page
        $pages->pageSize=30;
        $pages->applyLimit($criteria);

		return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>$pages,
            'sort'=>$sort,
		));
	}

public function phoneByID($id)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('user_id',$id);
		return Profile::model()->findAll($criteria);
	}
    
	public function clientsSearch()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->with = array('user');
		$criteria->compare('`user`.`username`',$this->userUsername,true);
		$criteria->compare('`user`.`email`',$this->userEmail,true);
		$criteria->compare('`user`.`superuser`','0');
                
        $sort = new CSort;
        $sort->defaultOrder = '`lastname` ASC, `firstname` ASC';

        $count=$this->count($criteria);
        $pages=new CPagination($count);

        // results per page
        $pages->pageSize=30;
        $pages->applyLimit($criteria);

		return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>$pages,
            'sort'=>$sort,
		));
	}
    
	
    
    
	public static function getListData() {
        $array = Profile::model()->findAll(array(
            'order' => '`lastname` ASC, `firstname` ASC',
        ));
        
        return CHtml::listData($array, 'user_id', function($data) {return $data->getUniqueName();});
	}
	
    
    
    
	public static function getClientsData() {
        $array = Profile::model()->findAll(array(
            'with' => array(
                'user' => array(
                    'condition' => '`superuser` < 2',
                ),
            ),
            'order' => '`lastname` ASC, `firstname` ASC',
        ));
        
        return CHtml::listData($array, 'user_id', function($data) {return $data->name;});
	}
	
    
    
    
	public function getPhotoPreview() {
        if (empty($this->photo))
            $src = Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/img/blank_photo.png';
        else
            $src = Yii::app()->request->hostInfo.'/resources/users/200_'.$this->photo;
        
        return CHtml::link(CHtml::image($src), $this->user->profileUrl);
	}
	
    
    
    
	public function getRawPhoto($photo_number = 'photo') {
        if (empty($this->$photo_number))
            $src = Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/img/blank_photo.png';
        else
            $src = Yii::app()->request->hostInfo.'/resources/users/600_'.$this->$photo_number;
        
        return $src;
	}
	
    
    
    
	public function getSquarePhoto($photo_number = 'photo') {
        if (empty($this->$photo_number))
            $src = Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/img/blank_photo.png';
        else
            $src = Yii::app()->request->hostInfo.'/resources/users/200_'.$this->$photo_number;
        
        return $src;
	}
	
    
    
    
	public function getFullCity() {
        $full = array();
        
        if (!empty($this->city))
            $full[] = $this->city;
        
        if (!empty($this->country))
            $full[] = $this->country->code;
        
        return implode(', ', $full);
	}
	
    
    
    
	public function getProfileProgress() {
        $result = array(
            'Personal Info' => 10,
            'Social' => 10,
            'Photos' => 10,
            'Documents' => 10,
            'Phones' => 10,
            'Account' => 10,
            'Total' => 0,
            'Improvements' => array(),
        );
        
        if (!empty($this->firstname)) $result['Personal Info'] += 15; else $result['Improvements']['Personal Info'][] = array('15', 'Add your first name');
        if (!empty($this->lastname)) $result['Personal Info'] += 15; else $result['Improvements']['Personal Info'][] = array('15', 'Add your last name');
        if (!empty($this->birthday)) $result['Personal Info'] += 15; else $result['Improvements']['Personal Info'][] = array('15', 'Add your birthday');
        if (!empty($this->is_company)) $result['Personal Info'] += 15; else $result['Improvements']['Personal Info'][] = array('15', 'Mark yourself as a company');
        if (!empty($this->country_id)) $result['Personal Info'] += 15; else $result['Improvements']['Personal Info'][] = array('15', 'Add your country');
        if (!empty($this->city)) $result['Personal Info'] += 15; else $result['Improvements']['Personal Info'][] = array('15', 'Add your city');
        
        if (stristr($this->user->social_identity, 'FB')) $result['Social'] += 45; else $result['Improvements']['Social'][] = array('45', 'Connect Facebook account');
        if (stristr($this->user->social_identity, 'GP')) $result['Social'] += 45; else $result['Improvements']['Social'][] = array('45', 'Connect Google + account');
        
        if (!empty($this->photo)) $result['Photos'] += 30; else $result['Improvements']['Photos'][] = array('30', 'Add avatar');
        if (!empty($this->photo2)) $result['Photos'] += 30; else $result['Improvements']['Photos'][] = array('30', 'Add portrait');
        if (!empty($this->photo3)) $result['Photos'] += 30; else $result['Improvements']['Photos'][] = array('30', 'Add other photo');
        
        if (!empty($this->user->approvedMyDocuments)) $result['Documents'] = 100; else $result['Improvements']['Documents'][] = array('100', 'Upload scan of your ID card');
        
        if (!empty($this->public_phone)) $result['Phones'] += 45; else $result['Improvements']['Phones'][] = array('45', 'Add phone number');
        if (!empty($this->alter_phone)) $result['Phones'] += 45; else $result['Improvements']['Phones'][] = array('45', 'Add alter phone number');
        
        if ($this->user->status == User::STATUS_ACTIVE) $result['Account'] = 100; else $result['Improvements']['Account'][] = array('100', 'Activate your account');
        
        $result['Total'] = round(($result['Personal Info'] + $result['Social'] + $result['Photos'] + $result['Documents'] + $result['Phones'] + $result['Account']) / 6);
        
        return $result;
	}
}