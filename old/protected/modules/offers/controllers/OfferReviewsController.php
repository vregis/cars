<?php

class OfferReviewsController extends Controller
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
				'actions'=>array('add', 'index', 'archived'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd($id)
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        $r1 = false;
        $r2 = false;
        
        $order = Orders::model()->findByPk($id);
        
        //Add Offer Review
        $offer_model=new OfferReviews;
        $offer_model->order_id = $id;
        $offer_model->offer_id = $order->offer_id;
        
        $offer_photomodel = new OfferReviewPhotos;
        $offer_photomodel->review_id = $id;

        if(isset($_POST['OfferReviews']))
        {
            $offer_model->attributes = $_POST['OfferReviews'];
            
            $r1 = $offer_model->save();
            
            if ($r1 && isset($_POST['OfferReviewPhotos'])) {
                $r = true;
                $images = CUploadedFile::getInstances($offer_photomodel,'filename');

                if (!empty($images)) 
                    foreach ($images as $key => $image) {
                        $offer_photomodel = new OfferReviewPhotos;
                        $offer_photomodel->instance = $image;
                        $offer_photomodel->review_id = $offer_model->id;
                        $offer_photomodel->save();
                    }            
            }
        }
        
        
        //Add User Review
        $user_model=new UserReviews;
        $user_model->order_id = $id;
        $user_model->user_id = $order->offer->owner_id;

        if(isset($_POST['UserReviews']))
        {
            $user_model->attributes=$_POST['UserReviews'];

            $r2 = $user_model->save();
        }
        
        
        //Go back to order if done
        if ($r1*$r2) 
            $this->redirect(array('/orders/default/edit', 'id' => $id));
        
        

        $this->render('add',array(
            'offer_model'=>$offer_model,
            'offer_photomodel'=>$offer_photomodel,
            'user_model'=>$user_model,
        ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
        Yii::app()->theme = 'backend';

        $model=new OfferReviews;
        $model->offer_id = $id;

        if(isset($_POST['OfferReviews']))
        {
            $model->attributes=$_POST['OfferReviews'];

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

        if(isset($_POST['OfferReviews']))
        {
            $model->attributes=$_POST['OfferReviews'];

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

        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'id' => $offer_id));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id)
	{   
        Yii::app()->theme = 'backend';

        $model=new OfferReviews('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['OfferReviews']))
            $model->attributes=$_GET['OfferReviews'];
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
	 * @return OfferReviews the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OfferReviews::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OfferReviews $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='offer-reviews-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
