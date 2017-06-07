<?php

/**
 * This is the model class for table "offer_documents".
 *
 * The followings are the available columns in table 'offer_documents':
 * @property integer $id
 * @property integer $offer_id
 * @property string $filename
 * @property string $date_uploaded
 * @property integer $is_approved
 * @property integer $approved_by
 * @property string $date_approved
 *
 * The followings are the available model relations:
 * @property Offers $offer
 * @property Users $approvedBy
 */
class OfferDocuments extends CActiveRecord
{
    private $file_fields = array('filename');
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OfferDocuments the static model class
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
		return 'offer_documents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('offer_id, title', 'required'),
			array('offer_id, is_approved, approved_by', 'numerical', 'integerOnly'=>true),
			array('filename, title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, offer_id, title, date_uploaded, is_approved, approved_by, date_approved', 'safe'),
			array('filename', 'unsafe'),
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
			'offer_id' => Yii::t('app', 'Offer'),
			'title' => Yii::t('app', 'Name'),
			'filename' => Yii::t('app', 'File'),
			'date_uploaded' => Yii::t('app', 'Date uploaded'),
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
		$criteria->compare('offer_id',$this->offer_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('date_uploaded',$this->date_uploaded,true);
		$criteria->compare('is_approved',$this->is_approved);
		$criteria->compare('approved_by',$this->approved_by);
		$criteria->compare('date_approved',$this->date_approved,true);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`date_uploaded` ASC';
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
        $this->removeFiles();
                 
        return parent::beforeDelete();
    }
        
        
	/**
	 * Save resources and do preparations.
	 * @return Boolean
	 */
    protected function beforeSave()
    {        
        $this->prepareFiles();
        
        if ($this->isNewRecord) {
            if (empty($this->filename)) {
                $this->addError('filename', Yii::t('app', 'Please, add file.'));

                return false;
            }
            
            $this->date_uploaded = date('Y-m-d H:i:s');       
        }
        
        if ($this->changed('filename')) {
            $old = $this->findByPk($this->id);
            $old->removeFiles();
            
            $this->approved_by = NULL;
            $this->date_approved = NULL;
            $this->is_approved = 0;
        }     
        
        return parent::beforeSave();
    }
    

    protected function afterSave()
    {        
        $this->saveFiles();

        return parent::afterSave();
    }
    
    
    public function getSourcesPath() {
        return dirname(__FILE__).'/../../../../resources/documents/';
    }

    
    public function removeFiles($only_field = NULL)
    {        
        if (!empty($this->file_fields)) 
            foreach ($this->file_fields as $field) {
                if (empty($only_field) || $only_field == $field) {
                    if (is_file($this->sourcesPath.$this->$field))
                        unlink($this->sourcesPath.$this->$field);
                }
            }
        
        return true;
    }

    
    public function prepareFiles()
    {            
        if (!empty($this->file_fields)) 
            foreach ($this->file_fields as $field) {
                $$field = CUploadedFile::getInstance($this, $field);

                if (isset($$field)) {
                    $this->removeFiles($field);

                    $uname = date('YmdHis').'_'.substr(md5(uniqid(rand(), true)), 0, rand(7, 13)).'.'.$$field->extensionName;
                    $this->$field = $uname;
                }
            }
        
        return true;
    }

    
    public function saveFiles()
    {    
        if (!empty($this->file_fields)) 
            foreach ($this->file_fields as $field) {
                $$field = CUploadedFile::getInstance($this, $field);

                if (isset($$field)) 
                    $$field->saveAs($this->sourcesPath.$this->$field);
            }    
        
        return true;
    }
}