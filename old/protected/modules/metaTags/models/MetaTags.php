<?php

/**
 * This is the model class for table "meta_tags".
 *
 * The followings are the available columns in table 'meta_tags':
 * @property integer $id
 * @property string $route
 * @property string $title
 * @property string $description
 * @property string $keywords
 */
class MetaTags extends CActiveRecord
{
    
    public $preview_sizes = array(
        'image' => array(
            array('width' => 300, 'height' => 300, 'pre' => '300'),
        )
    );
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MetaTags the static model class
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
		return 'meta_tags';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, route', 'required'),
			array('name, route', 'length', 'max'=>255),
			array('title', 'length', 'max'=>500),
			array('description, keywords', 'length', 'max'=>1000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, route, title, description, keywords', 'safe'),
			array('image', 'unsafe'),
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
			'name' => Yii::t('app', 'Internal page name'),
			'route' => Yii::t('app', 'Yii route to page'),
			'title' => Yii::t('app', 'Title'),
			'description' => Yii::t('app', 'Description'),
			'keywords' => Yii::t('app', 'Keywords'),
			'image' => Yii::t('app', 'Preview image'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('route',$this->route,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('keywords',$this->keywords,true);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;

        // results per page
        $pages->pageSize=50;
        $pages->applyLimit($criteria);

		return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>$pages,
            'sort'=>$sort,
		));
	}

    
    
	public function siteSearch($text)
	{
        $criteria=new CDbCriteria;

        $criteria->compare('route',$text,true,'OR');
        $criteria->compare('title',$text,true,'OR');
        $criteria->compare('description',$text,true,'OR');
        $criteria->compare('keywords',$text,true,'OR');

        $sort = new CSort;                
        $sort->defaultOrder = '`title` ASC';                 
        $sort->multiSort = false;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => false,                
            'sort'=>$sort,
        ));
	}
        
        
	
    public static function setMetaData($controller)
    {
        $original_route = array();
        
        if (!empty($controller->module))
            $original_route[] = $controller->module->id;
        $original_route[] = $controller->id;
        $original_route[] = $controller->action->id;
        
        $metaTag = MetaTags::model()->findByAttributes(array(
            'route' => implode('/', $original_route)
        ));
        
        if (!empty($metaTag)) {
            Yii::app()->clientScript->registerMetaTag($metaTag->description, 'description');
            Yii::app()->clientScript->registerMetaTag($metaTag->keywords, 'keywords');
            $controller->pageTitle = $metaTag->title;
            if (!empty($metaTag->image)) {
                Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.'/resources/articles/'.$metaTag->image, NULL, NULL, array('property'=>'og:image'));            
                Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.'/resources/articles/300_'.$metaTag->image, NULL, NULL, array('property'=>'og:image'));            
            }
            
            $result = true;
        } else
            $result = false;
        
        return $result;
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
        return dirname(__FILE__).'/../../../../resources/articles/';
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
}