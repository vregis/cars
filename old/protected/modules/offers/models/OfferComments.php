<?php

/**
 * This is the model class for table "offer_comments".
 *
 * The followings are the available columns in table 'offer_comments':
 * @property integer $id
 * @property integer $offer_id
 * @property integer $author_id
 * @property integer $parent_id
 * @property string $text
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property Offers $offer
 * @property Users $author
 */
class OfferComments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OfferComments the static model class
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
		return 'offer_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('offer_id, author_id, text', 'required'),
			array('offer_id, author_id, parent_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, offer_id, author_id, parent_id, text, date_created', 'safe'),
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
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'parent' => array(self::BELONGS_TO, 'OfferComments', 'parent_id'),
			'children' => array(self::HAS_MANY, 'OfferComments', 'parent_id', 'order' => '`date_created` ASC'),
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
			'author_id' => Yii::t('app', 'Author'),
			'parent_id' => Yii::t('app', 'Parent comment'),
			'text' => Yii::t('app', 'Text'),
			'date_created' => Yii::t('app', 'Date created'),
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
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('date_created',$this->date_created,true);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`date_created` ASC';
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
        if (!empty($this->children)) 
            foreach ($this->children as $comment) {
                $comment->parent_id = $this->parent_id;
                $comment->save();
            }
            
        return parent::beforeDelete();
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
        
        
    /*
     * 
     */        
    public static function getTree($offer_id, $parent_id = 0) 
    {               
        if ($parent_id != 0) {
            $params = array(':parent_id'=>$parent_id, ':offer_id'=>$offer_id);
            $condition = '`parent_id` = :parent_id AND `offer_id` = :offer_id';
        } else {
            $params = array(':offer_id'=>$offer_id);
            $condition = '`parent_id` IS NULL AND `offer_id` = :offer_id';
        }

        $siblings = OfferComments::model()->findAll(array('condition'=>$condition, 'params'=>$params, 'order'=>'`date_created` ASC'));

        $arr = array();
        if (!empty($siblings)) {
            foreach ($siblings as $key => $sibling) {
                $item = array(
                    'model' => $sibling, 
                );

                $children = OfferComments::getTree($offer_id, $sibling->id);
                if (!empty($children))
                    $item['children'] = $children;
                else
                    $item['children'] = NULL;

                $arr[] = $item;
            }
        }

        return $arr;
    }
        
        
    /*
     * 
     */        
    public function getPretext ($maxlen = 120) {
        $text = $this->text;
        if (mb_strlen($text) > $maxlen)
            $text = mb_substr($text, 0, 120, 'UTF-8').'...';
        
        return $text;
    }
}