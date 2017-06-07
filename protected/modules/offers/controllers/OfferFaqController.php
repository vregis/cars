<?php

class OfferFaqController extends Controller
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
				'actions'=>array('add','edit','index','delete'),
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

    
    
	public function actionAdd($id)
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model=new OfferFaq;
        $model->offer_id = $id;
        
        if ($model->offer->owner_id != Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');
        
        $max_order = OfferFaq::model()->find(array(
            'condition' => '`offer_id` = :offer_id',
            'params' => array(':offer_id' => $id),
            'order' => '`order` DESC',
        ));
        if (!empty($max_order))
            $model->order = $max_order->order + 10;

        if(isset($_POST['OfferFaq']))
        {
            $model->attributes=$_POST['OfferFaq'];

            if ($model->save()) {
                $this->redirect(array('index', 'id' => $id));
            }
        }

        $this->render('add',array(
            'model'=>$model,
        ));
	}

    
    
	public function actionEdit($id)
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model=$this->loadModel($id);
        
        if ($model->offer->owner_id != Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');

        if(isset($_POST['OfferFaq']))
        {
            $model->attributes=$_POST['OfferFaq'];

            if ($model->save()) {  
                $this->redirect(array('index', 'id' => $model->offer_id));
            }
        }

        $this->render('edit',array(
            'model'=>$model,
        ));
	}

    
    
	public function actionIndex($id)
	{   
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model=new OfferFaq('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['OfferFaq']))
            $model->attributes=$_GET['OfferFaq'];
        $model->offer_id = $id;
        
        if ($model->offer->owner_id != Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');

        if (isset($_GET['ajax'])) {
            $this->renderPartial('indexgrid',array(
                'model'=>$model,
            ));
        }
        else {
            $this->render('index',array(
                'model'=>$model,
            ));
        }
	}
    
    

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
        Yii::app()->theme = 'backend';

        $model=new OfferFaq;
        $model->offer_id = $id;

        if(isset($_POST['OfferFaq']))
        {
            $model->attributes=$_POST['OfferFaq'];

            if ($model->save()) {
                $this->redirect(array('admin', 'id' => $id));
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

        if(isset($_POST['OfferFaq']))
        {
            $model->attributes=$_POST['OfferFaq'];

            if ($model->save()) {  
                $this->redirect(array('admin', 'id' => $model->offer_id));
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
        $offer_id = $model->offer_id;
                
        if (!Yii::app()->user->isAdmin() && !(Yii::app()->user->id == $model->offer->owner_id))
            return false;  

        $model->delete();
        
        if (Yii::app()->user->isAdmin())
            $return_manual = array('admin', 'id' => $offer_id);
        else
            $return_manual = array('index', 'id' => $offer_id);        

        if(!isset($_GET['ajax']))             
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $return_manual);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id)
	{   
        Yii::app()->theme = 'backend';

        $model=new OfferFaq('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['OfferFaq']))
            $model->attributes=$_GET['OfferFaq'];
        $model->offer_id = $id;

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
	 * @return OfferFaq the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OfferFaq::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OfferFaq $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='offer-faq-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
