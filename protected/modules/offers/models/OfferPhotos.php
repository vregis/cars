<?php

/**
 * This is the model class for table "offer_photos".
 *
 * The followings are the available columns in table 'offer_photos':
 * @property integer $id
 * @property integer $offer_id
 * @property string $filename
 * @property integer $order
 *
 * The followings are the available model relations:
 * @property Offers $offer
 */
class OfferPhotos extends CActiveRecord
{    
    public $preview_sizes = array(
        'filename' => array(
            array('width' => 200, 'height' => 200, 'pre' => '200'),
            array('width' => 400, 'height' => 400, 'pre' => '400'),
            array('width' => 600, 'pre' => '600'),
        )
    );
    
    public $instance;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OfferPhotos the static model class
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
		return 'offer_photos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('offer_id', 'required'),
			array('offer_id, order', 'numerical', 'integerOnly'=>true),
			array('filename', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, offer_id, order', 'safe'),
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
			'filename' => Yii::t('app', 'Photos'),
			'order' => Yii::t('app', 'Sorting order'),
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
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('order',$this->order);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`order` ASC';
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
        $this->removeImages();
            
        return parent::beforeDelete();
    }
        
        
	/**
	 * Save resources and do preparations.
	 * @return Boolean
	 */
    protected function beforeSave()
    {     
        $this->prepareImages();
        
        return parent::beforeSave();
    }
    

    protected function afterSave()
    {        
        $this->saveImages();

        return parent::afterSave();
    }
    
    
    public function getSourcesPath() {
        return dirname(__FILE__).'/../../../../resources/offers/';
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
}