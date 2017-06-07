<?php

class DefaultController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/backend', meaning
	 * using backend layout. See 'protected/views/layouts/backend.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view','additions'),
				'users'=>array('*'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('order', 'checkDates', 'index', 'archived', 'addToFavourites', 'add', 'edit', 'delete', 'unlock', 'activate','additions'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('create','update','admin','getData'),
				'users'=>Yii::app()->user->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    

    
	public function actionOrder($id)
	{
        $this->layout='//layouts/one_column';
        
        $model=new Orders;
        $model->client_id = Yii::app()->user->id;
        $model->offer_id = $id;
        $model->amount=1;  
        $model->date_since = date('Y-m-d H:i');  
        $model->date_for = date('Y-m-d H:i');  
        if(isset($_POST['Orders']))
        {
            $model->attributes=$_POST['Orders'];
            $model->client_id = Yii::app()->user->id;
            $model->offer_id = $id;      
            $model->price_daily = $model->offer->price_daily;
            $model->price_hourly = $model->offer->price_hourly;
            $model->paypal_id = $model->offer->paypal_id;
                    
            $dates = explode(' ~ ', $model->dates_split);
            if (count($dates) == 2) {
                $model->date_since = $dates[0];
                $model->date_for = $dates[1];
            }
            
            if ($model->save()) {    
                if (!empty($model->orderedOptions))
                    foreach ($model->orderedOptions as $option) {
                        $option->delete();
                    }
                        
                if (isset($_POST['OfferOptions'])) {
                    foreach ($_POST['OfferOptions'] as $option_id) {
                        $option = new OrderedOptions;
                        $option->order_id = $model->id;
                        $option->option_id = $option_id;
                        $option->save();
                    }
                }
                
                $this->redirect(array('/my/orders/~e'.$model->id.'/pay'));
            }
        }
        
        if (isset($_POST['opt'])) {
            $a_options = array($_POST['opt']);
            if(isset($_POST['optadd']))
                $a_options=array_merge($a_options,$_POST['optadd']);
        } elseif (isset($_POST['OfferOptions'])) {
            $a_options = $_POST['OfferOptions'];
        } else{
            //$a_options = array();
            $this->redirect(array('/s/~o'.$id));
        }

        foreach($model->offer->publicOptions as $optx){
            if($optx['attributes']['main_option'] && in_array($optx['attributes']['main_option_id'], $a_options)){

                break;
            }
        }
        $total_cost=0;
        foreach ($optx->additions as $key => $addi) {
           if(in_array($addi['id'], $a_options))
                $total_cost+=$addi['price_daily'];

        }
        $this->render('order',array(
            'model'=>$model,
            'a_options'=>$a_options,
            'mo'=>$optx,
            'total_cost'=>$total_cost
        ));
	}
    
    
    public function actionAdditions()
    {
        $additionsHTML='';
        if(isset($_POST['main_option_id'])){
            $additions =  $this->additionsByID($_POST['main_option_id']);
            foreach($additions as $addi){
                   $additionsHTML.= $this->renderPartial('/offerOptions/_viewadd', array('data' => $addi),true);
                }
        }
        echo $additionsHTML;
    }

    public function additionsByID($id)
    {
            
            return OfferOptions::model()->getAdditions($id);

               
    }


	public function actionActivate($id)
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model=$this->loadModel($id);
        //$model->status = Offers::STATUS_ACTIVE;
        $model->save();

        $this->render('activate',array(
            'model'=>$model
        ));
	}
    
    

    
	public function actionCheckDates()
	{
        if (!isset($_POST['offer_id']) || !isset($_POST['dates'])) return false;
        
        $offer = Offers::model()->findByPk($_POST['offer_id']);
        if (empty($offer)) return false;
        
        $dates = explode(' ~ ', $_POST['dates']);
        if (count($dates) != 2) return false;
        
        $blocks = $offer->getBlocksArray($dates[0], $dates[1]);
        
        if (!empty($blocks)) {
            $blocks_array = OfferBlocks::formatForList($blocks);
            echo implode('<br/>', $blocks_array);
        }
        
        return true;
	}

    
    
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = new Offers('search');
        $model->unsetAttributes();
        
        $this->render('index',array(
            'model'=>$model,
        ));
	}

    
    
	/**
	 * Lists all models.
	 */
	public function actionArchived()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = new Offers('search');
        $model->unsetAttributes();
        
        $this->render('archived',array(
            'model'=>$model,
        ));
	}
    
    

    
	public function actionAdd()
	{
// here was romka
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model=new Offers;
        $model->owner_id = Yii::app()->user->id;
        $model->status = Offers::STATUS_ACTIVE;

        if(isset($_POST['Offers']))
        {
            $model->attributes=$_POST['Offers'];
            $model->status = Offers::STATUS_PASSIVE;

            if ($model->save()) {                
                $this->redirect(array('edit', 'id'=>$model->id, 'master'=>'go'));
            }
        }

        $this->render('add',array(
            'model'=>$model,
        ));
	}
    
    
    
	public function actionEdit($id)
	{
        //here was romka
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model=$this->loadModel($id);
        $address_model=new UserAddresses;
        $address_model->user_id = Yii::app()->user->id;

        if(isset($_POST['Offers']))
        {
            
            $model->attributes=$_POST['Offers'];

            if ($model->save()) {  
                if (!empty($model->offersAddresses))
                    foreach ($model->offersAddresses as $addr) {
                        $addr->delete();
                    }
                        
                if (isset($_POST['UserAddrCheckboxes'])) {
                    foreach ($_POST['UserAddrCheckboxes'] as $address_id) {
                        $address = new OffersAddresses;
                        $address->offer_id = $model->id;
                        $address->address_id = $address_id;
                        $address->save();
                    }
                }
                
                if (isset($_POST['continue']))
                    //$this->redirect(array('/offers/offerBlocks/index', 'id'=>$model->id, 'master' => 'go'));
                    $this->redirect(array('/offers/offerPhotos/index', 'id'=>$model->id));
                else
                    $this->redirect(array('edit', 'id'=>$model->id));
            }
        }
        
        if (isset($_GET['master']) || ($model->status == Offers::STATUS_PASSIVE)) { 
            if (isset($_POST['UserAddrCheckboxes']) && !empty($model->offersAddresses))
                foreach ($model->offersAddresses as $addr) {
                    $addr->delete();
                }

            if (isset($_POST['UserAddrCheckboxes'])) {
                foreach ($_POST['UserAddrCheckboxes'] as $address_id) {
                    $address = new OffersAddresses;
                    $address->offer_id = $model->id;
                    $address->address_id = $address_id;
                    $address->save();
                }
            }
                
            if (isset($_POST['UserAddresses'])) {
                $address_model->attributes=$_POST['UserAddresses'];

                if ($address_model->save()) {
                    $address = new OffersAddresses;
                    $address->offer_id = $model->id;
                    $address->address_id = $address_model->id;
                    if ($address->save()) {                   
                    }
                }
            }
            
            if (isset($_POST['continue']))
                //$this->redirect(array('/offers/offerBlocks/index', 'id'=>$model->id, 'master' => 'go'));
                $this->redirect(array('/offers/offerPhotos/index', 'id'=>$model->id));
            elseif (isset($_POST['save']))
                $this->redirect(array('edit', 'id'=>$model->id, 'master' => 'go'));
        }
        
        $a_addresses_list = CHtml::listData($model->addresses, 'id', 'id');
        $a_addresses = array_keys($a_addresses_list);

        $this->render('edit',array(
            'model'=>$model,
            'address_model'=>$address_model,
            'a_addresses'=>$a_addresses,
        ));
	}

    
    
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $this->layout='//layouts/one_column';
        
        $model = $this->loadModel($id);
        if (isset($_POST['comment_text']) && isset($_POST['parent_id'])) {
            $comment = new OfferComments;
            $comment->offer_id = $id;
            $comment->author_id = Yii::app()->user->id;
            if (!empty($_POST['parent_id']))
                $comment->parent_id = $_POST['parent_id'];
            else
                $comment->parent_id = NULL;
            $comment->text = CHtml::encode($_POST['comment_text']);
            
            if ($comment->save())
                $this->redirect(array('/offers/default/view', 'id' => $id, '#' => 'offer-tabs'));
        }

        $this->render('view',array(
            'model'=>$model,
            'additions'=>$this->additionsByID($model->publicOptions[0]->id),
        ));
	}
    
    

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::app()->theme = 'backend';

        $model=new Offers;

        if(isset($_POST['Offers']))
        {
            $model->attributes=$_POST['Offers'];

            if ($model->save()) {                
                $this->redirect(array('update', 'id'=>$model->id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        Yii::app()->theme = 'backend';

        $model=$this->loadModel($id);

        if(isset($_POST['Offers']))
        {
            $model->attributes=$_POST['Offers'];

            if ($model->save()) {  
                if (!empty($model->offersAddresses))
                    foreach ($model->offersAddresses as $addr) {
                        $addr->delete();
                    }
                        
                if (isset($_POST['UserAddresses'])) {
                    foreach ($_POST['UserAddresses'] as $address_id) {
                        $address = new OffersAddresses;
                        $address->offer_id = $model->id;
                        $address->address_id = $address_id;
                        $address->save();
                    }
                }
                
                $this->redirect(array('admin'));
            }
        }
        
        $a_addresses_list = CHtml::listData($model->addresses, 'id', 'id');
        $a_addresses = array_keys($a_addresses_list);

        $this->render('update',array(
            'model'=>$model,
            'a_addresses'=>$a_addresses,
        ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $model = $this->loadModel($id);
                
        if (!Yii::app()->user->isAdmin() && !(Yii::app()->user->id == $model->owner_id))
            return false;  

        if (Yii::app()->user->isAdmin())
            $model->delete();
        else {
            $model->status = Offers::STATUS_ARCHIVED;
            $model->save();
        }        
        
        if (Yii::app()->user->isAdmin())
            $return_manual = array('admin');
        else
            $return_manual = array('index');        

        if(!isset($_GET['ajax']))             
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $return_manual);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionUnlock($id)
	{
        $model = $this->loadModel($id);
                
        if (Yii::app()->user->id != $model->owner_id)
            return false;  

        $model->status = Offers::STATUS_ACTIVE;
        $model->save();

        if(!isset($_GET['ajax']))             
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{   
        Yii::app()->theme = 'backend';

        $model=new Offers('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Offers']))
            $model->attributes=$_GET['Offers'];

        if (isset($_GET['ajax'])) {
            $this->renderPartial('admingrid',array(
                'model'=>$model,
            ));
        }
        else {
            $this->render('admin',array(
                'model'=>$model,
            ));
        }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Offers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Offers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Offers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='offers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    
	/**
	 * Return getListData array for AJAX
	 * @return JSON
	 */
	public function actionGetData($q)
	{
		$raw_data = Offers::model()->findAll(array(
            'condition' => '`title` LIKE :q AND `status` = 1',
            'params' => array(':q' => '%'.$q.'%'),
        ));
        $data_list = CHtml::listData($raw_data, 'id', function($data) {return $data->title;});
        
        $data = array();
        if (!empty($data_list))
            foreach ($data_list as $key => $value) {
                $data[] = array('id' => $key, 'text' => $value);
            }
        
        echo json_encode($data);

        Yii::app()->end();
	}

    
	/**
	 * Save to favourites
	 * @return JSON
	 */
	public function actionAddToFavourites()
	{
        if (isset($_POST['id'])) {
            $offer = Offers::model()->findByPk($_POST['id']);
            if (!empty($offer)) {
                $exist = UserFavourites::model()->findByAttributes(array(
                    'user_id' => Yii::app()->user->id,
                    'offer_id' => $_POST['id']
                ));
                
                if (empty($exist)) {
                    $model = new UserFavourites;
                    $model->user_id = Yii::app()->user->id;
                    $model->offer_id = $_POST['id'];
                    echo $model->save();
                } else {
                    echo $exist->delete();
                }
            }
        }

        Yii::app()->end();
	}
}
