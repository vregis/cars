<?php

class FormSearch extends CModel
{
    public $location, $type, $date_since, $date_for, $rating, $privates, $approved;
    public $lat, $lng;
    public $sort = 6;
    public $offset, $limit;
    
    CONST LATLNG_DIFF = 0.3; //Area of +/- 0.3 degree (or about 30 km) to search in
    
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('location, type, date_since, date_for, rating', 'safe'),
		);
	}
    
    
	public function attributeNames()
	{
		return array(
			'location' => 'Location',
			'type' => 'Type',
			'date_since' => 'Date_since',
			'date_for' => 'Date_for',
			'rating' => 'Rating',
			'privates' => 'Only Privates',
			'approved' => 'Approved',
		);
	}
    
    
	public function attributeLabels()
	{
		return array(
			'location' => 'Location',
			'type' => 'Type',
			'date_since' => 'Date_since',
			'date_for' => 'Date_for',
			'rating' => 'Rating',
			'privates' => 'Only Privates',
			'approved' => 'Approved',
		);
	}
    
    
    
	public function processParameters()
	{
        /*
         * LOCATION FILTER
         */
        //Set location by Google Place ID
        if (isset($_GET['lid'])) {
            $request_url = 'https://maps.googleapis.com/maps/api/place/details/json?placeid='.$_GET['lid'].'&key='.Yii::app()->params['GooglePlacesAPI'];
            $response_json = file_get_contents($request_url);

            $response_obj = json_decode($response_json);

            if (
                $response_obj->status == 'OK' &&
                !empty($response_obj->result) &&
                !empty($response_obj->result->geometry) &&
                !empty($response_obj->result->geometry->location)
            ) {
                $this->lat = $response_obj->result->geometry->location->lat;
                $this->lng = $response_obj->result->geometry->location->lng;
                
                $this->location = $response_obj->result->formatted_address;
            }       
        } else            
        //Set location by it's name
        if (!empty($this->location)) {
            $text = urlencode(trim($this->location));
            
            $request_url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?query='.$text.'&key='.Yii::app()->params['GooglePlacesAPI'];
            $response_json = file_get_contents($request_url);

            $response_obj = json_decode($response_json);

            if ($response_obj->status == 'OK' && !empty($response_obj->results)) {
                $item = $response_obj->results[0];
                
                if (!empty($item->geometry) && !empty($item->geometry->location)) {
                    $this->lat = $item->geometry->location->lat;
                    $this->lng = $item->geometry->location->lng;
                }
            }
        }
        
        
        /*
         * DATE FILTER
         */
        //Set date
        if (isset($_GET['dd'])) {
            $dates = explode(' ~ ', $_GET['dd']);
            if (count($dates) == 2) {
                if (preg_match('/\d\d\d\d-\d\d-\d\d/', $dates[0]) && preg_match('/\d\d\d\d-\d\d-\d\d/', $dates[1])) {
                    $this->date_since = $dates[0];
                    $this->date_for = $dates[1];
                }                        
            }       
        }
        
        
        /*
         * CHECKBOXES
         */
        //Filter privates
        if (isset($_GET['po'])) 
            $this->privates = 1;
        else
            $this->privates = NULL;
        //Filter approved offers
        if (isset($_GET['ap'])) 
            $this->approved = 1;
        else
            $this->approved = NULL;
	}
    
    
    
	public function findOffers()
	{
        $criteria = new CDbCriteria();
        $criteria->with = array();
        
        $criteria->compare('t.status', Offers::STATUS_ACTIVE);
                
        //Filter by place
        if (!empty($this->lat) && !empty($this->lng)) {
            $criteria->with[] = 'addresses';
            $criteria->addBetweenCondition('`addresses`.lat', $this->lat - FormSearch::LATLNG_DIFF, $this->lat + FormSearch::LATLNG_DIFF);
            $criteria->addBetweenCondition('`addresses`.lng', $this->lng - FormSearch::LATLNG_DIFF, $this->lng + FormSearch::LATLNG_DIFF);
        }
                
        //Filter by type
        if (!empty($this->type)) {
            $types = explode(',', $this->type);
            
            $ids = array();
            if (!empty($types))
                foreach ($types as $type_id) {
                    $category = Categories::model()->findByPk($type_id);

                    if (!empty($category)) {
                        $ids[] = $category->id;
                        $ids = array_merge($ids, $category->getChildrenIds());
                    }
                }
                
            $criteria->addInCondition('`t`.category_id', $ids);
        }
                
        //Filter by privates
        if (!empty($this->privates)) {
            $criteria->with['owner'] = array('with' => array('profile'));
            $criteria->compare('`profile`.is_company', 0);
        }
                
        //Filter by approved offers
        if (!empty($this->approved)) {
            $criteria->compare('`t`.is_approved', 1);
        }
                
        //Filter by rating
        if (!empty($this->rating) && is_numeric($this->rating)) {
            $criteria->compare('`t`.rating >', $this->rating);
        }
                
        //Sort
        $order = array(
            'rating' => '`t`.rating DESC',
            //'distance' => '`t`.rating DESC',
            'price' => '`t`.price_hourly DESC',
        );
        if (!empty($this->sort)) {            
            if ($this->sort & 2) $order['rating'] = '`t`.rating ASC';
            if ($this->sort & 8) $order['price'] = '`t`.price_hourly ASC';
        }
        $criteria->order = implode(', ', $order);
        
        
        $items = Offers::model()->findAll($criteria);
        
        //Filter by date
        if (!empty($this->date_since) && !empty($this->date_for)) {
            if (!empty($items))
                foreach ($items as $k => $item) {
                    if ($item->isBlocked($this->date_since, $this->date_for))
                        unset($items[$k]);
                    elseif (!empty($item->orders))
                        foreach ($item->orders as $order) {
                            if (
                                in_array($order->status, array(Orders::STATUS_PAYMENT, Orders::STATUS_APPROVED)) &&
                                (
                                    ($order->date_since > $this->date_since && $order->date_since < $this->date_for) || 
                                    ($order->date_for_real > $this->date_since && $order->date_for_real < $this->date_for)
                                )
                            ) {
                                unset($items[$k]);
                            }
                        }
                }
        }
        
        
        //Pagination                
        $count = count($items);
        $pages = new CPagination($count);
        $pages->pageSize = 2;
        
        if (!empty($items))
            foreach ($items as $key => $item) {
                if (
                    $key < $pages->offset || 
                    $key >= ($pages->offset + $pages->limit)
                )
                    unset($items[$key]);
            }
                
        
        return array(
            'items' => $items,
            'pages' => $pages
        );
	}
    
    
    
    public function processMapPins($items, $return_assoc = true) {
        $pins = array();
        
        if (!empty($items))
            foreach ($items as $item) {
                if (!empty($item->addresses))
                    foreach ($item->addresses as $address) {
                        if (empty($pins[$address->id]))
                            $pins[$address->id] = array(
                                'coords' => array($address->lat, $address->lng),
                                'label' => Yii::app()->controller->renderPartial('/offers/default/_mapview', array('data' => $item), true),
                                'range' => $item->range
                            );                                
                        else {
                            $range = min(array($item->range, $pins[$address->id]['range']));
                            $label = $pins[$address->id]['label'].Yii::app()->controller->renderPartial('/offers/default/_mapview', array('data' => $item), true);

                            $pins[$address->id] = array(
                                'coords' => array($address->lat, $address->lng),
                                'label' => $label,
                                'range' => $range
                            ); 
                        }
                    }                    
            }
        else {
            $pins[] = array(
                'coords' => array($this->lat, $this->lng)
            ); 
        }
        
        
        if (!$return_assoc && !empty($pins)) {
            $pins_ext = array();
            foreach ($pins as $id => $arr) {
                $arr['id'] = $id;
                $pins_ext[] = $arr;
            }
            $pins = $pins_ext;
        }
        
        
        return $pins;
    }
}