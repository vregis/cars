<?php

class ParameterValuesController extends Controller
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
				'actions'=>array('admin','delete','setValue'),
				'users'=>Yii::app()->user->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $model = $this->loadModel($id);
        $parameter_id = $model->parameter_id;
        
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'id'=>$parameter_id));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id)
	{   
        Yii::app()->theme = 'backend';

        $model=new ParameterValues('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ParameterValues']))
            $model->attributes=$_GET['ParameterValues'];
        $model->parameter_id = $id;

        if (isset($_GET['ajax'])) {
            $this->renderPartial('admingrid',array(
                'model'=>$model,
            ));
        }
        else {
            $form_model = new ParameterValues;
            $form_model->parameter_id = $id;

            if(isset($_POST['ParameterValues']))
            {
                $form_model->attributes=$_POST['ParameterValues'];

                if ($form_model->save()) 
                    $this->redirect(array('admin', 'id'=>$id));
            }
            
            $this->render('admin',array(
                'model'=>$model,
                'form_model'=>$form_model
            ));
        }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ParameterValues the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ParameterValues::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ParameterValues $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='parameter-values-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Saves AJAX data for column order
	 * @return none
	 */
	public function actionSetValue()
	{
		if(isset($_POST['item']))
		{
            $model = $this->loadModel($_POST['item']);
            if (!empty($model)) {
                $model->value = $_POST['value'];
                echo $model->save();
            }

            Yii::app()->end();
		}
	}
}
