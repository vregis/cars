<?php
class feMap extends CWidget
{    
    /*
     * coords
     * address
     * label
     */
	public $pins = array();
    
    public $height = 400;
    
    public $center = NULL;
    
    private $map;
    
    public $containerOptions = array('style' => 'width: 100%');
    
    public $container = true;
    
    
	public function init()
	{
		$this->map = new EGMap();
        if (!empty($this->height))
            $this->map->setHeight($this->height);
        $this->map->setContainerOptions($this->containerOptions);
	}
    

	public function run()
	{        
		if (!empty($this->pins))
            foreach ($this->pins as $key => $pin) {
                if (empty($pin['coords']))
                    $latlng = $this->geocode($pin['address']);
                else
                    $latlng = $pin['coords'];
                
                if (!empty($pin['range']))
                    switch ($pin['range']) {
                        case 0: $icon = new EGMapMarkerImage(Yii::app()->theme->baseUrl.'/img/pin-success.png'); break;
                        case 1: $icon = new EGMapMarkerImage(Yii::app()->theme->baseUrl.'/img/pin-primary.png'); break;
                        case 2: $icon = new EGMapMarkerImage(Yii::app()->theme->baseUrl.'/img/pin-warning.png'); break;
                        default: $icon = new EGMapMarkerImage(Yii::app()->theme->baseUrl.'/img/pin-danger.png'); break;
                    }
                else
                    $icon = new EGMapMarkerImage(Yii::app()->theme->baseUrl.'/img/pin-success.png');
                $icon->setSize(20, 32);
                $icon->setAnchor(10, 32);
                $icon->setOrigin(0, 0);
                
                $this->map->addGlobalVariable('Marker'.$key);
                $marker = new EGMapMarker($latlng[0], $latlng[1], array('icon'=>$icon), 'Marker'.$key);
                
                if (!empty($pin['label'])) {
                    $this->map->addGlobalVariable('InfoWindow'.$key);
                    $infowindow = new EGMapInfoWindow($pin['label'], 'InfoWindow'.$key);
                    $marker->addHtmlInfoWindow($infowindow, false);
                }
                
                $this->map->addMarker($marker);                
            }
        else {
            $marker = new EGMapMarker($this->center[0], $this->center[1]);

            $this->map->addMarker($marker);     
        }
            
        if (is_array($this->center)) {
            $this->map->setCenter($this->center[0], $this->center[1]);
            $this->map->zoomOnMarkers(0.5);
        } elseif (is_string($this->center)) {
            $latlng = $this->geocode($this->center);
            
            $this->map->setCenter($latlng[0], $latlng[1]);
            $this->map->zoomOnMarkers(0.5);
        } else
            $this->map->centerAndZoomOnMarkers(0.5);
        
        if ($this->container)
            echo '<div class="map-container" data-bounds="'.$this->map->getBoundsFromCenterAndZoom().'">';
        $this->map->renderMap();
        if ($this->container)
            echo '</div>';
	}
    
    
    public function geocode($address) {        
        $loop = 0;
        $lat = 0;
        $lng = 0;
        while (empty($lat) && empty($lng) && $loop < 10) {
            $geocoded = new EGMapGeocodedAddress($address);
            $geocoded->geocode($this->map->getGMapClient());
            $lat = $geocoded->getLat();
            $lng = $geocoded->getLng();
            $loop++;
        }
        
        return array($lat, $lng);
    }
}