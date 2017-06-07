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
				'actions'=>array('index','archived','edit','delete','pay','setStatus'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('create','update','admin'),
				'users'=>Yii::app()->user->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    
    
	/**
	 * Lists all models.
	 */
	public function actionPay($id)
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = $this->loadModel($id);
        if ($model->client_id != Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');
        
        $payment = new Payments;
		$payment->order_id = $id;
		$payment->payment_type = 1;
		$payment->type = Payments::TYPE_REFILL;
		$payment->amount = $model->total_cost;

        if(!empty($model->paypal_id))
            $payment->paypal_id=$model->paypal_id; //pay merchant
        
       // var_dump($payment);
       // echo __FILE__;
        if ($payment->save()){ 
            PayPal::requestPayment($payment->id);
            $em=$model->client->email;
            $mail = new MailForms();
            $mail->sendNotification('New Order','Message: '.$payment->order_id.' from file: '.__FILE__, $em);
        }
	}

    
    
	/**
	 * Change Status
	 */
	public function actionSetStatus($id, $s)
	{
        $model = $this->loadModel($id);
        if ($model->client_id != Yii::app()->user->id && $model->offer->owner_id != Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');
        
        if (
            in_array($s, array(Orders::STATUS_NEW, Orders::STATUS_SUBMITTED)) && 
            $model->client_id == Yii::app()->user->id
        ) {
            $model->status = $s;
            $return = array('index', 't' => $s);
        }
        
        if (
            in_array($s, array(Orders::STATUS_PAYMENT)) && 
            $model->offer->owner_id == Yii::app()->user->id
        ) {
            $model->status = $s;
            
            $return = array('/orders/offered/view', 'id' => $id);
        }
        
        if (
            in_array($s, array(Orders::STATUS_SUCCESSFUL)) && 
            $model->client_id == Yii::app()->user->id
        ) {
            $model->status = $s;
            $return = array('/orders/default/edit', 'id' => $id);
        }
        
        if ($s == Orders::STATUS_CANCELED) {
            $model->status = $s;
            
            if ($model->offer->owner_id == Yii::app()->user->id)
                $return = array('/orders/offered/index');
            else
                $return = array('archived');
        }
        
        $model->save();
        
        $this->redirect($return);
	}

    
    
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = new Orders('search');
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
        
        $model = new Orders('search');
        $model->unsetAttributes();
        
        $this->render('archived',array(
            'model'=>$model,
        ));
	}
    
        
	public function actionEdit($id)
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = $this->loadModel($id);
        if ($model->client_id != Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');

        if(isset($_POST['Orders']))
        {
            $model->attributes = $_POST['Orders'];

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
                  
                $this->redirect(array('index'));
            }
        }
        
        $a_options_list = CHtml::listData($model->orderedOptions, 'option_id', 'option_id');
        $a_options = array_keys($a_options_list);

        $this->render('edit',array(
            'model'=>$model,
            'a_options'=>$a_options,
        ));
	}

    
    
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::app()->theme = 'backend';

        $model=new Orders;

        if(isset($_POST['Orders']))
        {
            $model->attributes=$_POST['Orders'];

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

        if(isset($_POST['Orders']))
        {
            $model->attributes=$_POST['Orders'];

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
                  
                $this->redirect(array('admin'));
            }
        }
        
        $a_options_list = CHtml::listData($model->orderedOptions, 'option_id', 'option_id');
        $a_options = array_keys($a_options_list);

        $this->render('update',array(
            'model'=>$model,
            'a_options'=>$a_options,
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
                
        if (!Yii::app()->user->isAdmin() && !(Yii::app()->user->id == $model->client_id))
            return false;  

        $model->delete();
        
        if (Yii::app()->user->isAdmin())
            $return_manual = array('admin');
        else
            $return_manual = array('index');        

        if(!isset($_GET['ajax']))             
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $return_manual);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{   
        Yii::app()->theme = 'backend';

        $model=new Orders('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Orders']))
            $model->attributes=$_GET['Orders'];

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
	 * @return Orders the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Orders::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Orders $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='orders-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
