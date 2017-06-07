<?php

class ListProvincesController extends Controller
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
				'actions'=>array('create','update','admin','delete','getData','getDataByCountry'),
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
	public function actionCreate($id)
	{
        Yii::app()->theme = 'backend';

        $model=new ListProvinces;
        $model->country_id = $id;

        if(isset($_POST['ListProvinces']))
        {
            $model->attributes=$_POST['ListProvinces'];

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

        if(isset($_POST['ListProvinces']))
        {
            $model->attributes=$_POST['ListProvinces'];

            if ($model->save()) {      
                $this->redirect(array('admin', 'id' => $model->country_id));
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
        $country_id = $model->country_id;

        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'id' => $country_id));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id)
	{   
        Yii::app()->theme = 'backend';

        $model=new ListProvinces('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ListProvinces']))
            $model->attributes=$_GET['ListProvinces'];
        $model->country_id = $id;

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
	 * @return ListProvinces the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ListProvinces::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ListProvinces $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='list-provinces-form')
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
		$raw_data = ListProvinces::model()->findAll(array(
            'condition' => '`name` LIKE :q OR `code` LIKE :q',
            'params' => array(':q' => '%'.$q.'%'),
        ));
        $data_list = CHtml::listData($raw_data, 'id', function($data) {return $data->fullName;});
        
        $data = array();
        if (!empty($data_list))
            foreach ($data_list as $key => $value) {
                $data[] = array('id' => $key, 'text' => $value);
            }
        
        echo json_encode($data);

        Yii::app()->end();
	}

    
	/**
	 * Return getListData array for AJAX
	 * @return JSON
	 */
	public function actionGetDataByCountry($country_id)
	{
		$raw_data = ListProvinces::model()->findAll(array(
            'condition' => '`country_id` = :country_id',
            'params' => array(':country_id' => $country_id),
        ));
        $data_list = CHtml::listData($raw_data, 'id', function($data) {return $data->fullName;});
        
        $htmlOptions = array('encode'=>true, 'empty' => 'Выберите область/провинцию...');
        echo CHtml::listOptions('', $data_list, $htmlOptions);

        Yii::app()->end();
	}
}
