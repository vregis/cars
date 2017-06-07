<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/one_column';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
        
    public $login_model = '';
        
    public $title = '';
        
	public $sidebar_minified = 0;
    
    public $parameters;
    
    public $category_id;
    
    private $_user_model;
    
    public $currency;
    
    public $categoryDropdown = false;
    
    public $popup = NULL;
    
    public $loginModel = NULL;
    
    
    public function __construct($id,$module=null){
        parent::__construct($id,$module);

        if (isset(Yii::app()->user->id)) {
            $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
            if (!empty($lastVisit)) {
                $lastVisit->lastvisit = time();
                $lastVisit->save();    
            }            
        }
        
        // Set the sidebar size
        if(isset(Yii::app()->request->cookies['sidebar_minified']) && (Yii::app()->request->cookies['sidebar_minified']->value == '1'))
            $this->sidebar_minified = 1; 
        
       
        /*
         * Set Language
         */    
        // If there is a post-request, redirect the application to the provided url of the selected language 
        if(isset($_POST['language'])) {
            $lang = $_POST['language'];
            if ($lang != 'en')
                $MultilangReturnUrl = $_POST[$lang];
            else
                $MultilangReturnUrl = '/site/index';
            $this->redirect($MultilangReturnUrl);
        }
        // Set the application language if provided by GET, session or cookie
        if(isset($_GET['language']) && !empty($_GET['language'])) {
            Yii::app()->language = $_GET['language'];
            Yii::app()->user->setState('language', $_GET['language']); 
            $cookie = new CHttpCookie('language', $_GET['language']);
            $cookie->expire = time() + (60*60*24*365); // (1 year)
            Yii::app()->request->cookies['language'] = $cookie; 
        } else {
            Yii::app()->language = 'en';
            Yii::app()->user->setState('language', Yii::app()->language); 
            $cookie = new CHttpCookie('language', Yii::app()->language);
            $cookie->expire = time() + (60*60*24*365); // (1 year)
            Yii::app()->request->cookies['language'] = $cookie;                 
        }
    }
    
    
        
    public function createMultilanguageReturnUrl($lang = 'en'){
        $arr = array();
        if (count($_GET)>0)
            $arr = $_GET;
        $arr['language'] = $lang;

        return $this->createUrl('', $arr);
    }
    
    
    public function getUserModel(){
        $ret_model = NULL;
        
        if (isset(Yii::app()->user->id)) {
            if (empty($this->_user_model)) {
                $this->_user_model = User::model()->findByPk(Yii::app()->user->id);
            }
            
            $ret_model = $this->_user_model;
        }
        
        return $ret_model;
    }
    
    
    public function plural($number, $one, $two, $five) {
        $full_number = $number;
        $number = $number % 100;
        
        if ($number>=11 && $number<=19)
            $ending = $five;
        else {
            $i = $number % 10;
            switch ($i) {
                case (1): $ending = $one; break;
                case (2):
                case (3):
                case (4): $ending = $two; break;
                default: $ending = $five;
            }
        }
        
        return $full_number.' '.$ending;
    }
    
    
	protected function beforeAction($action)
	{
        //Set META data if possible
        MetaTags::setMetaData($this);
        
        //Generate popup if needed
        Popups::prepare($this);
        
        //Create model for LoginForm
        if (Yii::app()->user->isGuest) {
            $this->loginModel = new UserLogin;
        }
        
       
        /*
         * Set Currency
         */    
        // Change the application currency
        if(isset($_GET['cuch']) && !empty($_GET['cuch'])) {
            Currencies::apply($_GET['cuch']);
            
            $params = $_GET;
            unset($params['cuch']);
            
            $this->redirect(array_merge(array($this->id.'/'.$this->action->id), $params));
        } else {
            if (!empty(Yii::app()->user->getState('currency')))
                $currency_id = Yii::app()->user->getState('currency');
            elseif (!empty(Yii::app()->request->cookies['currency']))
                $currency_id = Yii::app()->user->getState('currency');
            else
                $currency_id = Yii::app()->params['currency']['id'];
            
            Currencies::apply($currency_id);
        }
        
        return parent::beforeAction($action);
	}
    
    
    public function formatPrice($base_amount, $pre = NULL) {        
        $price = '<span class="text-success">'.$pre.Currencies::format($base_amount, Currencies::BASE).'</span>';
        
        //If currency not base
        if (Yii::app()->params['currency']['id'] != Yii::app()->params['base_currency']['id'])
            $price .= ' / '.Currencies::format($base_amount, Currencies::ACTUAL);
        
        return $price;
    }
    
    
    public function alterPrice($base_amount) {        
        $price = '';
        
        //If currency not base
        if (Yii::app()->params['currency']['id'] != Yii::app()->params['base_currency']['id']) {
            $price = Currencies::format($base_amount, Currencies::ACTUAL, false);
        }
        
        return $price;
    }
    
    
    public function formatText($text, $only_br = false) {
        $formatted = nl2br($text);
        
        if (!$only_br) {
            $formatted = str_replace('<br>','</p><p>',$formatted);
            $formatted = '<p>'.$formatted.'</p>';
        }
        
        return $formatted;
    }
}