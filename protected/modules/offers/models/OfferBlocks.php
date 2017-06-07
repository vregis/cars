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
class OfferBlocks extends CActiveRecord
{
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OfferBlocks the static model class
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
		return 'offer_blocks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('offer_id, date_since, date_for', 'required'),
			array('id, offer_id, date_since, date_for', 'safe'),
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
			'date_since' => Yii::t('app', 'Since'),
			'date_for' => Yii::t('app', 'For'),
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
		$criteria->compare('date_since',$this->date_since);
		$criteria->compare('date_for',$this->date_for);
                
        $count=$this->count($criteria);
        $pages=new CPagination($count);

        $sort = new CSort;
        $sort->defaultOrder = '`date_since` ASC';
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
        return parent::beforeDelete();
    }
        
        
	/**
	 * Save resources and do preparations.
	 * @return Boolean
	 */
    protected function beforeSave()
    {
        return parent::beforeSave();
    }
    
    
    public static function buildCalendar($month, $year, $blocks) {
        $daysOfWeek = array('Пн','Вт','Ср','Чт','Пт','Сб','Вс');
        $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
        $numberDays = date('t',$firstDayOfMonth);
        $dateComponents = getdate($firstDayOfMonth);

        $monthName = $dateComponents['month'];
        $dayOfWeek = $dateComponents['wday']-1; if ($dayOfWeek < 0) $dayOfWeek = 6;

        $calendar = "<table class='table table-calendar'>";
        $calendar .= "<thead><tr>";
        foreach ($daysOfWeek as $day) {
            $calendar .= "<th>$day</th>";
        } 
        $calendar .= "</tr></thead><tr>";

        $currentDay = 1;

        if ($dayOfWeek > 0) { 
            $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>"; 
        }

        $month = str_pad($month, 2, "0", STR_PAD_LEFT);

        while ($currentDay <= $numberDays) {

            if ($dayOfWeek == 7) {
                $dayOfWeek = 0;
                $calendar .= "</tr><tr>";
            }

            $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
            $date = "$year-$month-$currentDayRel";
            
            $class = '';
            if ($date == date('Y-m-d')) $class = 'today ';
            $cur = new DateTime($date);
            if (!empty($blocks))
                foreach ($blocks as $block) {
                    $since = new DateTime($block->date_since);
                    $for = new DateTime($block->date_for);
                    
                    $cur_since = new DateTime($date.' 00:00:00');
                    $cur_for = new DateTime($date.' 23:59:59');
                
                    if ($since <= $cur_since && $for > $cur_for)
                        $class = 'blocked';
                    elseif ((
                        ($since >= $cur_since && $since <= $cur_for) || 
                        ($for > $cur_since && $for <= $cur_for)
                    ) && empty($class))
                        $class = 'blocked-partial';
                }
            
            $calendar .= '<td class="'.$class.'" data-date="'.$date.'">'.$currentDay.'</td>';

            $currentDay++;
            $dayOfWeek++;
        }

        if ($dayOfWeek != 7) { 
            $remainingDays = 7 - $dayOfWeek;
            $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>"; 
        }

        $calendar .= "</tr>";
        $calendar .= "</table>";

        return $calendar;
    }
    
    
    public static function formatForList($blocks) {
        $blocked_arr = array();
        
        foreach ($blocks as $block) {
            if (Yii::app()->locale->dateFormatter->format('HH:mm', $block[0]) == '00:00') $date_since = 'dd.MM.yyyy'; else $date_since = 'dd.MM.yyyy H:mm';
            if (Yii::app()->locale->dateFormatter->format('HH:mm', $block[1]) == '00:00') $date_for = 'dd.MM.yyyy'; else $date_for = 'dd.MM.yyyy H:mm';
            $blocked_arr[] = Yii::app()->locale->dateFormatter->format($date_since, $block[0]).'&nbsp;&ndash;&nbsp;'.Yii::app()->locale->dateFormatter->format($date_for, $block[1]);
        }
        
        return $blocked_arr;
    }
}