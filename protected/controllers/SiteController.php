<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
            'sitemapxml'=>array(
                'class'=>'ext.sitemap.ESitemapXMLAction',
                'classConfig'=>array(
                    array('baseModel'=>'StaticPages',
                        'route'=>'/staticPages/default/view',
                        'params'=>array('url_name'=>'url_name'),
                        'priority'=>0.85,
                        'frequency'=>'monthly',
                    ),
                    array('baseModel'=>'News',
                        'route'=>'/news/default/view',
                        'params'=>array('url_name'=>'url_name'),
                        'priority'=>0.7,
                        'frequency'=>'monthly',
                    ),
                    'scopeName'=>'sitemap',
                ),
                //'bypassLogs'=>true, // if using yii debug toolbar enable this line
                'importListMethod'=>'getBaseSitePageList',
            ),   
		);
	}
        
        
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
            array('allow',  // deny all users
                'actions'=>array('index','search', 'sitemap', 'excel'),
                'users'=>array('*'),
            ),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index', 'search', 'siteSearch', 'feedback', 'currencies', 'languages', 'subscription', 'subscribed', 'unsubscribe', 'error', 'logout', 'sitemapxml', 'socialLogin', 'switchSidebar', 'gMapsAutocomplete','paypal'),
				//'users'=>array('*'),
                'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin', 'adminSearch', 'test', 'getJSONSitemap', 'imageGetJson', 'imageUpload', 'fileUpload'),
				'users'=>Yii::app()->user->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}




	public function actionGMapsAutocomplete()
	{        
        $text = urlencode(trim($_POST['text']));
        
        $result = array();
        
        $request_url = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?input='.$text.'&types=geocode&components=country:ru&key='.Yii::app()->params['GooglePlacesAPI'];
        $response_json = file_get_contents($request_url);
        
        $response_obj = json_decode($response_json);
        
        if ($response_obj->status == 'OK') {
            $predictions = $response_obj->predictions;
            if (!empty($predictions))
                foreach ($predictions as $item) {
                    //prepare string
                    $label = '';
                    if (!empty($item->matched_substrings)) {
                        $position = $item->matched_substrings[0];
                        $label .= mb_substr($item->description, 0, $position->offset);
                        $text_success=mb_substr($item->description, $position->offset, $position->length);
                        $label .= '<span class="text-success">'.$text_success.'</span>';
                        $label .= mb_substr($item->description, $position->offset+$position->length);
                    }
                    
                    //prepare icon
                    $item_type = $item->types[0];
                    $types = Places::model()->types;
                    $label = '<i class="fa fa-fw fa-compass '.$types[$item_type].'"></i>'.$label;
                    
                    //prepare link
                    //$result[] = '<li>'.CHtml::link($label, array('/site/search', 'lid' => $item->place_id)).'</li>';
                    //,'onclick'=>'javascript:alert("roman")'
                    $result[] = '<li>'.CHtml::link($label,'#',array('class'=>'inp_link','onclick'=>'$(\'#home-search-input\').val($(this).text());')).'</li>';
                    //prepare dropDOWN list
                    //$result[]=array($text_success=>$text_success);
                }
                //Yii::app()->clientScript->registerScript("set_location",'$(".inp_link").click(alert("hi roman"))');
                //Yii::app()->clientScript->registerScript('set_location','$(\'.container\').click(function(){alert(\'hi roman\')})');
                //Yii::app()->clientScript->registerScript('set_location','$(\'.container\').click(function(){alert(\'hi roman\')})');
                //$(#home-search-input).val($(this).html()); alert($(this).html());
               // print_r(Yii::app()->clientScript->scripts);
        }       
        
        echo implode(' ', $result);
        //echo CHtml::dropDownList('location_i',$result[0],$result);
        
        Yii::app()->end();
	}


        
        
	public function actionIndex()
	{
       /* $earthOffers = (new Categories())->getElementOffers(1);
        $waterOffers = (new Categories())->getElementOffers(2);
        $airOffers = (new Categories())->getElementOffers(3);

        $mergedOffers = array_merge($earthOffers, $waterOffers, $airOffers);
        shuffle($mergedOffers);*/

       $categories = new Categories();
       $mergedOffers = $categories->getRandomOffers();

        Yii::app()->theme = 'frontend';
        $this->layout = 'one_column';    
        
        $promoted = Offers::model()->findAll(array(
            'condition' => '`is_promo` = 1',
            'limit' => 6
        ));
        //roman

        $this->render('index', array(
            'promoted' => $promoted,
            'mergedOffers' => $mergedOffers,
        ));

        //require_once('/home/vorontra/kretivz.pro/getupway/themes/frontend/views/categories/_singleDropdown.php');

        ///////////////////////////////// roman test


	}


        
        
	public function actionSiteSearch($s)
	{
        Yii::app()->theme = 'frontend';
        $this->layout = 'one_column';  
        
        $criteria=new CDbCriteria;

		$criteria->compare('url_name',$s,true,'OR');
		$criteria->compare('menu_name',$s,true,'OR');
		$criteria->compare('title',$s,true,'OR');
		$criteria->compare('text',$s,true,'OR');
        
        $pages = StaticPages::model()->findAll($criteria);

        $this->render('siteSearch', array(
            'pages' => $pages,
            's' => $s
        ));
	}


        
        
	public function actionCurrencies()
	{        
        Yii::app()->theme = 'frontend';
        $this->layout = 'one_column';       

        $currencies = Currencies::model()->findAll(array(
            'order' => '`name` ASC'
        ));
        
        $this->render('currencies', array(
            'currencies' => $currencies
        ));
	}


        
        
	public function actionLanguages()
	{        
        Yii::app()->theme = 'frontend';
        $this->layout = 'one_column';      
        
        $languages = Yii::app()->params['languages'];

        $this->render('languages', array(
            'languages' => $languages
        ));
	}


        
        
	public function actionSitemap()
	{        
        Yii::app()->theme = 'frontend';
        $this->layout = 'one_column';

        $staticPages = (new StaticPages())->getAllStaticPages();
        $articles = (new Articles())->getAllArticles();
        $categories = (new Categories())->getAllCategory();
        
        $this->render('sitemap', array(
            'articles' => $articles,
            'staticPages' => $staticPages,
            'categories'  => $categories
        ));
	}


        
        
	public function actionSearch()
	{
        Yii::app()->theme = 'frontend';
        $this->layout = 'one_column';
        
        $model = new FormSearch;
        if (isset($_GET['l']) && !empty($_GET['l'])) $model->location = $_GET['l'];
        if (isset($_GET['t']) && !empty($_GET['t'])) $model->type = $_GET['t'];
        if (isset($_GET['s']) && !empty($_GET['s'])) $model->rating = $_GET['s'];
        if (isset($_GET['st']) && !empty($_GET['st'])) $model->keyword = $_GET['st'];
        if (isset($_GET['age_from']) && !empty($_GET['age_from'])) $model->age_from = $_GET['age_from'];
        if (isset($_GET['age_to']) && !empty($_GET['age_to'])) $model->age_to = $_GET['age_to'];
        if (empty($_GET['dd'])) {
            $cur_date = new DateTime();
            
            $model->date_since = $cur_date->format('Y-m-d');
            $model->date_for = $cur_date->add(new DateInterval('P1M'))->format('Y-m-d');
        }
            
        if (isset($_GET['sort'])) $model->sort = $_GET['sort'];
        
        $model->processParameters();
        
        $result = $model->findOffers();
                
        if (isset($_POST['ajax'])) {
            $return = array();
            
            $return['html'] = $this->renderPartial('/offers/default/_searchdata', array('items' => $result['items']), true);
            
            $return['map'] = $model->processMapPins($result['items'], false);
            
            echo json_encode($return);
            Yii::app()->end();
        } else
            $this->render('search', array(            
                'model'=>$model,
                'items'=>$result['items'],
                'pages'=>$result['pages'],
            ));
	}


        
        
	public function actionFeedback()
	{        
        $this->layout='//layouts/one_column';
        Yii::app()->theme = 'frontend';
        $result = NULL;
        
        $model = new FormFeedback();
        
        if (isset($_POST['FormFeedback'])) {
            $model->attributes=$_POST['FormFeedback'];
            
            if ($model->validate()) {            
                $title = 'New feedback from MyRentClub.com';

                $message = 'Hello,<br /><br />you\'ve achieved new message from feedback form at MyRentClub.com.<br /><br />';

                $message .= '<strong>Reason: '.$model->reasons[$model->reason].'</strong><br />';
                $message .= 'Name: '.$model->name.'<br />';
                $message .= 'E-mail: '.$model->email.'<br />';
                $message .= 'Message: '.$model->notes;

                $mail = new MailForms();
                $result = $mail->sendNotification($title, $message, SiteVars::v('FEEDBACK_EMAIL'));
            } else
                $result = false;
        }            

        $this->render('feedback', array(
            'result' => $result,
            'model' => $model,
        ));
	}


        
        
	public function actionSubscription()
	{        
        $this->layout='//layouts/one_column';
        Yii::app()->theme = 'frontend';
        $result = NULL;
        
        $model = new Subscribers;
        
        if (isset($_GET['email'])) {
            $model->email = $_GET['email'];
        }
        
        if (isset($_POST['Subscribers']) && isset($_POST['accepted'])) {
            $model->attributes=$_POST['Subscribers'];
            $model->date_created = date('Y-m-d H:i:s');
            
            if ($model->save()) {            
                $title = 'Новый подписчик на сайте «'.Yii::app()->name.'»';

                $message = 'Здравствуйте,<br /><br />Вы получили нового подписчика на сайте «'.Yii::app()->name.'».<br /><br />';

                $message .= 'Имя: '.$model->name.'<br />';
                $message .= 'E-mail: '.$model->email;

                $mail = new MailForms();
                $result = $mail->sendNotification($title, $message, SiteVars::v('ADMIN_EMAIL'));
                
                if ($result)
                    $this->redirect(array('/site/subscribed', 'id'=>$model->id));
            } else
                $result = false;
        } elseif (isset($_POST['Subscribers'])) {
            $model->attributes=$_POST['Subscribers'];
            $model->addError('accepted', 'Accept personal data use for subscription.');
            $result = false;
        }

        $this->render('subscription', array(
            'result' => $result,
            'model' => $model,
        ));
	}


        
        
	public function actionSubscribed($id)
	{        
        $this->layout='//layouts/one_column';
        Yii::app()->theme = 'frontend';
        
        $model = Subscribers::model()->findByPk($id);
        if (empty($model))
            throw new CHttpException(404,'The requested page does not exist.');

        $this->render('subscribed', array(
            'model' => $model,
        ));
	}


        
        
	public function actionUnsubscribe()
	{        
        $this->layout='//layouts/one_column';
        Yii::app()->theme = 'frontend';
        $result = NULL;
        
        if (isset($_GET['email'])) {
            $model = Subscribers::model()->findByAttributes(array('email' => $_GET['email']));
            if (!empty($model)) $result = $model->delete(); else $result = false;
        }

        $this->render('unsubscribe', array(
            'result' => $result
        ));
	}
    
    

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionAdmin()
	{
        $this->layout='//layouts/main';
        Yii::app()->theme = 'backend';

        $this->render('admin', array(
        ));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', array('error' => $error));
	    }
	}

	/**
	 * Displays the login page
	 */
	public function actionSocialLogin()
	{
            $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
            $user = json_decode($s, true);
            //$user['network'] - соц. сеть, через которую авторизовался пользователь
            //$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
            //$user['first_name'] - имя пользователя
            //$user['last_name'] - фамилия пользователя
            
            $model = new UserLogin;
            $model->username = $user['email'];
            $model->social_identity = $user['identity'];
            
            if ($model->socialLogin()) {
                $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
                $lastVisit->lastvisit = time();
                $lastVisit->save();

                if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
                    $this->redirect(Yii::app()->getModule('user')->returnUrl);
                else
                    $this->redirect(Yii::app()->user->returnUrl);
            } else {
                $raw_password = $user['uid'].'dv.t2_aFb!!Cdg';
                
                $db_user = new User;
                $db_user->username = $user['network'].'_'.$user['uid'];
                $db_user->password=md5($raw_password);
                if (!empty($user['email']))
                    $db_user->email=$user['email'];
                else
                    $db_user->email=$user['network'].'_'.$user['uid'].'@tmpmail.ru';
                $db_user->activkey = $user['network'];
                $db_user->social_identity = $user['identity'];
                $db_user->createtime=time();
                $db_user->lastvisit=time();
                $db_user->superuser=0;
                $db_user->status=1;
                $r = $db_user->save();
                
                $s = $db_user->id;
                
                $db_profile = new Profile;
                $db_profile->regMode = true;
                $db_profile->user_id = $db_user->id;
                $db_profile->firstname = $user['first_name'];
                $db_profile->lastname = $user['last_name'];
                $db_profile->save();
                
                $model->username = $user['email'];
                $model->password = $raw_password;
                
                if ($model->validate()) {
                    if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
                        $this->redirect(Yii::app()->getModule('user')->returnUrl);
                    else
                        $this->redirect(Yii::app()->user->returnUrl);
                }
            }
            
            CVarDumper::dump($user, 10, true);
            Yii::app()->end();
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionGetJSONSitemap()
	{
            $links = array(
                array('name' => 'Выберите из списка...', 'url' => false),
            );
            
            $staticPages = StaticPages::model()->findAll(array(
                'order' => '`order` ASC',
            ));
            if (!empty($staticPages))
                foreach ($staticPages as $page) {
                    $links[] = array('name' => $page->menu_name, 'url' => Yii::app()->createAbsoluteUrl('/staticPages/staticPages/view', array('url_name'=>$page->url_name)));
                }
            
            echo json_encode($links);
            return true;
	}
        
    public function actionImageGetJson() {

        $dir = dirname(__FILE__).'/../../resources/articles/thumbs/';

        $files = array();
        // Открыть заведомо существующий каталог и начать считывать его содержимое
        if (is_dir($dir)) {
           if ($dh = opendir($dir)) {
               while (($file = readdir($dh)) !== false) {
                   if ($file != '.' && $file != '..')
                       $files[] = array(
                           'thumb' => Yii::app()->request->hostInfo.'/resources/articles/thumbs/'.$file,
                           'image' => Yii::app()->request->hostInfo.'/resources/articles/'.$file,
                           'title' => $file,
                       );
               }
               closedir($dh);
           }
        }

        echo json_encode($files);	

    }

    public function actionImageUpload() {

        $image=CUploadedFile::getInstanceByName('file');

        $filename = 'a_'.date('YmdHis').'_'.substr(md5(time()), 0, rand(7, 13)).'.'.$image->extensionName;
        $path = dirname(__FILE__).'/../../resources/articles/'.$filename;
        $image->saveAs(dirname(__FILE__).'/../../resources/articles/'.$filename);
        $image_open = Yii::app()->image->load(dirname(__FILE__).'/../../resources/articles/'.$filename);

        if (isset($image_open)) {
            if ($image_open->width > $image_open->height) $dim = Image::HEIGHT; else $dim = Image::WIDTH;
            $image_open->resize(100, 100, $dim)->crop(100, 100);
            $image_open->save(dirname(__FILE__).'/../../resources/articles/thumbs/'.$filename);
        }

        $array = array(
        'filelink' => Yii::app()->request->hostInfo.'/resources/articles/'.$filename,
        'filename' => $filename
        );

        echo stripslashes(json_encode($array));	

    }

    public function actionFileUpload() {

        $image=CUploadedFile::getInstanceByName('file');

        $filename = date('YmsHis').'_'.substr(md5(time()), 0, rand(7, 13)).'.'.$image->extensionName;
        $path = dirname(__FILE__).'/../../resources/files/'.$filename;
        copy($_FILES['file']['tmp_name'], $path);
        $array = array(
            'filelink' => Yii::app()->request->hostInfo.'/resources/files/'.$filename,
            'filename' => $_FILES['file']['name']
        );

        echo stripslashes(json_encode($array));

        $json_file = fopen(dirname(__FILE__).'/../../resources/files/list.json', 'r');
        $json_raw = fread($json_file, filesize(dirname(__FILE__).'/../../resources/files/list.json'));
        fclose($json_file);
        $json = json_decode($json_raw);

        $bytes = sprintf('%u', filesize($path));
        if ($bytes >= 1073741824)
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        elseif ($bytes >= 1048576)
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        elseif ($bytes >= 1024)
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        elseif ($bytes > 1)
            $bytes = $bytes . ' bytes';
        elseif ($bytes == 1)
            $bytes = $bytes . ' byte';
        else
            $bytes = '0 bytes';

        $json[] = array(
            'link' => Yii::app()->request->hostInfo.'/resources/files/'.$filename,
            'name' => $filename,
            'size' => $bytes,
            'title' => $_FILES['file']['name'],
        );

        $json_file = fopen(dirname(__FILE__).'/../../resources/files/list.json', 'w');
        fwrite($json_file, json_encode($json));
        fclose($json_file);

    }

    public function getBaseSitePageList() {

            $list = array(
                array(
                    'loc'=>Yii::app()->createAbsoluteUrl('/'),
                    'frequency'=>'weekly',
                    'priority'=>'1',
                    ),     
                array(
                    'loc'=>Yii::app()->createAbsoluteUrl('/stockCars/index'),
                    'frequency'=>'weekly',
                    'priority'=>'0.9',
                    ), 
                array(
                    'loc'=>Yii::app()->createAbsoluteUrl('/cars/index'),
                    'frequency'=>'monthly',
                    'priority'=>'0.85',
                    ),   /*
                array(
                    'loc'=>Yii::app()->createAbsoluteUrl('/cars/prices'),
                    'frequency'=>'monthly',
                    'priority'=>'0.85',
                    ),  */           
                array(
                    'loc'=>Yii::app()->createAbsoluteUrl('/news/default/index'),
                    'frequency'=>'weekly',
                    'priority'=>'0.8',
                    ),          
                array(
                    'loc'=>Yii::app()->createAbsoluteUrl('/actions/default/index'),
                    'frequency'=>'weekly',
                    'priority'=>'0.9',
                    ),                 
                array(
                    'loc'=>Yii::app()->createAbsoluteUrl('/site/testDrive'),
                    'frequency'=>'monthly',
                    'priority'=>'0.8',
                    ),              
                array(
                    'loc'=>Yii::app()->createAbsoluteUrl('/site/feedback'),
                    'frequency'=>'monthly',
                    'priority'=>'0.7',
                    ),              
                array(
                    'loc'=>Yii::app()->createAbsoluteUrl('/site/subscription'),
                    'frequency'=>'monthly',
                    'priority'=>'0.7',
                    ),           
                array(
                    'loc'=>Yii::app()->createAbsoluteUrl('/site/sitemap'),
                    'frequency'=>'monthly',
                    'priority'=>'0.7',
                    ),         
            );
            
            return $list;
        }

        
        
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionSwitchSidebar($sidebar_minified)
	{        
        if ($sidebar_minified != 1)
            $sidebar_minified = 0;

        $cookie = new CHttpCookie('sidebar_minified', $sidebar_minified);
        $cookie->expire = time() + (60*60*24*365); // (1 year)
        Yii::app()->request->cookies['sidebar_minified'] = $cookie;

        Yii::app()->end();
        return true;
	}
    

    
    public function actionAdminSearch($text, $page = 1)
    {
        $this->layout='//layouts/main';
        Yii::app()->theme = 'backend';
        
        $time_start = microtime(true);

        $output = 5;
        $pageSize = $output;
        $offset = ($page - 1)*$output;
        
        $search_models = array(
            Accessories::model(),
            Actions::model(),
            Badges::model(),
            Banners::model(),
            CarDownloads::model(),
            CarInfoBlocks::model(),
            CarModifications::model(),
            Cars::model(),
            Categories::model(),
            Galleries::model(),
            MetaTags::model(),
            News::model(), 
            Notifications::model(),
            SiteVars::model(),
            SliderImages::model(),
            StaticPages::model(),
            StockCars::model(),
            Videos::model(),
        );
        
        foreach ($search_models as $search_model) {
            //$class_name = strtolower(get_class($search_model));
            $data[] = $search_model->siteSearch($text);
        }
        
        $count = 0;
        $j = 1;
        foreach ($data as $key => $material) {
            $count += $material->totalItemCount;
            $diff = $offset - $material->totalItemCount;
            if ($diff >= 0) {
                $data[$key] = '';
                $offset = $diff;
            } else {
                $skip = $offset;
                $offset = 0;
                //Deleting $skip items from beginning
                $tmp_arr = array();
                $tmp_arr = $material->getData();
                $res_arr = array();
                
                for ($i = $skip; $i<$material->totalItemCount; $i++) {
                    $res_arr[] = $tmp_arr[$i];
                }
                
                $data[$key]->setData($res_arr);
                $data[$key]->setTotalItemCount(count($res_arr));
                $material->setData($res_arr);
                
                $d = $output - $material->totalItemCount;
                if ($d >= 0) 
                    $output = $d;
                else {
                    //Delete all after $output items from $material
                    $tmp_arr = $material->getData();
                    $res_arr = array();
                    for ($i = 0; $i<$output; $i++) {
                        $res_arr[] = $tmp_arr[$i];
                    }
                    $data[$key]->setData($res_arr);
                    $output =0;
                }
            }
            $j++;
        }
        
        $vars = array();
        foreach ($search_models as $key => $search_model) {
            $class_name = strtolower(get_class($search_model));
            
            $vars[$class_name] = $data[$key];
        }
        
        $pages=new CPagination($count);
        
        // results per page
        $pages->pageSize=$pageSize;
        $pages->pageVar='page';
        $pages->params = array('text'=>$text);
        $pages->route = '/site/adminSearch';
         
        
        $time_finish = microtime(true);
        $query_time = round($time_finish - $time_start, 2);
        
        $vars['text'] = $text;
        $vars['total'] = $count;
        $vars['query_time'] = $query_time;
        $vars['pages'] = $pages;
        
        $this->render('search', $vars);
    }

    public function actionExcel()
    {
        include '/var/www/cars.local/lib/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        var_dump($objPHPExcel);
        die();
    }
}
