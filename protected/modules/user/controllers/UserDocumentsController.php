<?php

class UserDocumentsController extends Controller
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
				'actions'=>array('index','add','delete'),
				'users'=>array('*'),
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
    
    
	public function actionIndex()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model=new UserDocuments('frontendSearch');
        $model->unsetAttributes();        
        
        $this->render('index', array(
            'model'=>$model,
        ));
	}
    

	public function actionAdd()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model=new UserDocuments;
        $model->user_id = Yii::app()->user->id;

        if(isset($_POST['UserDocuments']))
        {
            $model->title = $_POST['UserDocuments']['title'];

            if ($model->save()) 
                $this->redirect(array('index'));
        }

        $this->render('add',array(
            'model'=>$model,
        ));
	}
    

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
        Yii::app()->theme = 'backend';

        $model=new UserDocuments;
        $model->user_id = $id;

        if(isset($_POST['UserDocuments']))
        {
            $model->attributes=$_POST['UserDocuments'];

            if ($model->save()) {
                $this->redirect(array('admin', 'id'=>$id));
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

        if (isset($_POST['approveDoc']) && !$model->is_approved) {
            $model->is_approved = 1;
            $model->approved_by = Yii::app()->user->id;
            $model->date_approved = date('Y-m-d H:i:s');
            $model->save();
            
            $this->redirect(array('update', 'id' => $model->id));
        }

        if(isset($_POST['UserDocuments']))
        {
            $model->attributes=$_POST['UserDocuments'];

            if ($model->save()) {
                $this->redirect(array('admin', 'id'=>$model->user_id));
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
                
        if (!Yii::app()->user->isAdmin() && !(Yii::app()->user->id == $model->user_id))
            return false;  
        
        $user_id = $model->user_id;

        $model->delete();
        
        if (Yii::app()->user->isAdmin())
            $return_manual = array('admin', 'id'=>$user_id);
        else
            $return_manual = array('index');        

        if(!isset($_GET['ajax']))             
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $return_manual);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id)
	{   
        Yii::app()->theme = 'backend';

        $model=new UserDocuments('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['UserDocuments']))
            $model->attributes=$_GET['UserDocuments'];
        $model->user_id = $id;

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
	 * @return UserDocuments the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=UserDocuments::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param UserDocuments $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-documents-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
