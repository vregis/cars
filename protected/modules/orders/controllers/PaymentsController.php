<?php

class PaymentsController extends Controller
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
			array('allow', // allow admin user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('income', 'outcome', 'view', 'requestWithdraw'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('create','update','admin','delete'),
				'users'=>Yii::app()->user->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionRequestWithdraw()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';

        $model = new Payments;
        
        if(isset($_POST['Payments']))
        {
            $model->amount = $_POST['Payments']['amount'];
            $model->order_id = NULL;
            $model->client_id = Yii::app()->user->id;
            $model->payment_type = 1;
            $model->type = Payments::TYPE_WITHDRAW;
            $model->date_created = date('Y-m-d H:i:s');
            $model->is_approved = NULL;
            $model->approved_by = NULL;
            $model->date_approved = NULL;

            if ($model->save())
                $this->redirect(array('requestWithdraw', 'sent' => 1));
            else {
                CVarDumper::dump($model->errors, 10, true);
                exit();
            }
        }

        $this->render('requestWithdraw',array(
            'model'=>$model,
        ));
	}

    
    
	/**
	 * Lists all models.
	 */
	public function actionIncome()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = new Payments('search');
        $model->unsetAttributes();
        
        $this->render('income',array(
            'model'=>$model,
        ));
	}

    
    
	/**
	 * Lists all models.
	 */
	public function actionOutcome()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = new Payments('search');
        $model->unsetAttributes();
        
        $this->render('outcome',array(
            'model'=>$model,
        ));
	}

    
    
	public function actionView($id)
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = $this->loadModel($id);
        
        if ($model->order->client_id != Yii::app()->user->id && $model->client_id != Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');
        
        $this->render('view',array(
            'model'=>$model,
        ));
	}
    
    

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::app()->theme = 'backend';

        $model=new Payments;

        if(isset($_POST['Payments']))
        {
            $model->attributes=$_POST['Payments'];

            if ($model->save()) {
                $this->redirect(array('admin'));
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

        if(isset($_POST['Payments']))
        {
            $model->attributes=$_POST['Payments'];

            if ($model->save()) {  
                $this->redirect(array('admin'));
            }
        }

        $this->render('update',array(
            'model'=>$model,
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

        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{   
        Yii::app()->theme = 'backend';

        $model=new Payments('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Payments']))
            $model->attributes=$_GET['Payments'];

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
	 * @return Payments the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Payments::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Payments $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='payments-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
