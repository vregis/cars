<?php

class SubscribersController extends Controller
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
				'actions'=>array('add','remove'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('create','update','admin','delete','export'),
				'users'=>Yii::app()->user->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
    
	public function actionAdd($email)
	{
        $subscriber = new Subscribers;
        $subscriber->email = $email;
        $subscriber->date_created = date('Y-m-d H:i:s');
        $r = $subscriber->save();
        
        echo $r;
        return $r;
    }

	
    /*
     * Parameter "u" is md5 of date_created
     */
	public function actionRemove($email, $u)
	{
        $subscriber = Subscribers::model()->findByAttributes(array(
            'email' => $email
        ));
        
        if (!empty($subscriber)) {
            if (md5($subscriber->date_created) == $u)
                $r = $subscriber->delete();
            else
                $r = false;
        }            
        
        echo $r;
        return $r;
    }

	
    
	public function actionExport($type)
	{
        $data = Subscribers::model()->export($type);
        
        switch ($type) {
            case 'csv': $extension = 'csv'; $mime = 'text/csv'; break;
            default: $extension = 'csv'; $mime = 'text/csv'; break;
        }
        
        $filename = date('Y-m-d H:i:s').'-subscribers.'.$extension;
        Yii::app()->request->sendFile($filename, $data, $mime);
        
        return true;
    }
    
    

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::app()->theme = 'backend';

        $model=new Subscribers;
        $model->date_created = date('Y-m-d H:i:s');

        if(isset($_POST['Subscribers']))
        {
            $model->attributes=$_POST['Subscribers'];

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

        if(isset($_POST['Subscribers']))
        {
            $model->attributes=$_POST['Subscribers'];

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

        $model=new Subscribers('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Subscribers']))
            $model->attributes=$_GET['Subscribers'];

        if (isset($_GET['ajax'])) {
            $this->renderPartial('admingrid',array(
                'model'=>$model,
            ));
        }
        else {
            $form_model = new Subscribers;
            $form_model->date_created = date('Y-m-d H:i:s');

            if(isset($_POST['Subscribers']))
            {
                $form_model->attributes=$_POST['Subscribers'];
                
                if ($form_model->save())
                    $this->redirect(array('admin'));
            }
            
            $this->render('admin',array(
                'form_model'=>$form_model,
                'model'=>$model,
            ));
        }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Subscribers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Subscribers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Subscribers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='subscribers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
