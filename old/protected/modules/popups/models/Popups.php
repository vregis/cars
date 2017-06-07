<?php

/**
 * This is the model class for table "popups".
 *
 * The followings are the available columns in table 'popups':
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $link
 * @property string $html
 * @property integer $delay
 * @property integer $period
 * @property string $date_expires
 * @property integer $views
 */
class Popups extends CActiveRecord
{
    
    public $preview_sizes = array(
        'image' => array(
            array('width' => 300, 'pre' => '300'),
        )
    );
    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Popups the static model class
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
		return 'popups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('delay, period, views', 'numerical', 'integerOnly'=>true),
			array('title, image, link', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, image, link, html, delay, period, date_expires, views', 'safe'),
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
			'title' => Yii::t('app', 'Name'),
			'image' => Yii::t('app', 'Image'),
			'link' => Yii::t('app', 'Link'),
			'html' => Yii::t('app', 'HTML code'),
			'delay' => Yii::t('app', 'Show time, sec'),
			'period' => Yii::t('app', 'Period between displays, min'),
			'date_expires' => Yii::t('app', 'Expiration date'),
			'views' => Yii::t('app', 'Views'),
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('html',$this->html,true);
		$criteria->compare('delay',$this->delay);
		$criteria->compare('period',$this->period);
		$criteria->compare('date_expires',$this->date_expires,true);
		$criteria->compare('views',$this->views);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`title` ASC';
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
    
    

    protected function beforeDelete()
    {       
        $this->removeImages();

        return parent::beforeDelete();
    }
    

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
        return dirname(__FILE__).'/../../../../resources/popups/';
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
                $$field = CUploadedFile::getInstance($this, $field);

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
                $$field = CUploadedFile::getInstance($this, $field);

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
    
    
    public static function prepare($controller) {
		$criteria = new CDbCriteria;
		$criteria->compare('date_expires', '>='.date('Y-m-d H:i:s'));        
        $actual_popups = Popups::model()->findAll($criteria);
        
        if (!empty($actual_popups))
            foreach ($actual_popups as $k => $popup) {
                if (!empty(Yii::app()->request->cookies['popup-'.$popup->id]->value)) 
                    unset($actual_popups[$k]);        
            }
            
        if (!empty($actual_popups)) {
            shuffle($actual_popups);            
            $popup = $actual_popups[0];
            
            $cookie = new CHttpCookie('popup-'.$popup->id, $popup->id);
            $cookie->expire = time() + (60*$popup->period);
            Yii::app()->request->cookies['popup-'.$popup->id] = $cookie; 
            
            $controller->popup = $popup;
            
            $popup->views += 1;
            $popup->save();
        }        
        
        return true;
    }
}