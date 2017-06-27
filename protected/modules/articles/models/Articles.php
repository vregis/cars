<?php

/**
 * This is the model class for table "articles".
 *
 * The followings are the available columns in table 'articles':
 * @property integer $id
 * @property string $url_name
 * @property string $title
 * @property string $image
 * @property string $annotation
 * @property string $text
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $date_created
 * @property integer $visible
 * @property integer $author_id
 */
class Articles extends CActiveRecord
{
    
    public $preview_sizes = array(
        'image' => array(
            array('width' => 300, 'height' => 300, 'pre' => '300'),
            array('width' => 500, 'height' => 500, 'pre' => '500'),
        )
    );
    
    public $categories = array('Земля', 'Вода', 'Воздух');
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Articles the static model class
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
		return 'articles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, title, annotation, text', 'required'),
			array('visible, author_id', 'numerical', 'integerOnly'=>true),
			array('image, meta_title', 'length', 'max'=>255),
			array('annotation, meta_description, meta_keywords', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category_id, url_name, title, annotation, text, meta_title, meta_description, meta_keywords, date_created, visible, author_id', 'safe'),
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
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => Yii::t('app', 'Стихия'),
			'url_name' => Yii::t('app', 'URL name'),
			'title' => Yii::t('app', 'Title'),
			'image' => Yii::t('app', 'Preview image'),
			'annotation' => Yii::t('app', 'Annotation'),
			'text' => Yii::t('app', 'Text'),
			'meta_title' => Yii::t('app', 'META Title'),
			'meta_description' => Yii::t('app', 'META Description'),
			'meta_keywords' => Yii::t('app', 'META Keywords'),
			'date_created' => Yii::t('app', 'Date created'),
			'visible' => Yii::t('app', 'Show on site'),
			'author_id' => Yii::t('app', 'Author'),
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('url_name',$this->url_name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('annotation',$this->annotation,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('visible',$this->visible);
		$criteria->compare('author_id',$this->author_id);
                
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
	 * Special scope for sitemap extension.
	 * @return Array
	 */
    public function scopes()
    {
        return array(
            'sitemap'=>array('select'=>'url_name', 'condition'=>'visible = 1'),
        );
    }


    /*
     * 
     */
    public static function translit($str) {
        $str = CHtml::encode($str);
        $output = file_get_contents(Yii::app()->params['transliteration_url'].$str);

        return $output;
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
   
        if ($this->isNewRecord) {
            $this->author_id = Yii::app()->user->id;
            $this->date_created = date('Y-m-d H:i:s');
        }
        
        if (empty($this->url_name))
            $this->url_name = Articles::translit($this->title);
            
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

    public function getAllArticles()
    {
        return $this->findAll();
    }
}