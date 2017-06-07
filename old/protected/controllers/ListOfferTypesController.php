<?php

class ListOfferTypesController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('create','update','admin','delete','setOrder'),
				'users'=>Yii::app()->user->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $this->layout='//layouts/one_column';
        
        $model = $this->loadModel($id);

        $this->render('view',array(
            'model'=>$model,
        ));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $this->layout='//layouts/one_column';

        $dataProvider=new CActiveDataProvider('ListOfferTypes');
        
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::app()->theme = 'backend';

        $model=new ListOfferTypes;

        if(isset($_POST['ListOfferTypes']))
        {
            $model->attributes=$_POST['ListOfferTypes'];

            /*
            if (isset($_POST['image_delete'])) {
                if (is_file(dirname(__FILE__).'/../../resources/'.$model->image))
                    unlink(dirname(__FILE__).'/../../resources/'.$model->image);

                $model->image = NULL;
            }

            $image=CUploadedFile::getInstance($model,'image');
            if (isset($image)){
                $image_uname=substr(md5(uniqid(rand(), true)), 0, rand(7, 13)).'.'.$image->extensionName;
                $model->image = $image_uname;
            }
            */

            if ($model->save()) {
                /*
                if (isset($image)) {
                    $image->saveAs(dirname(__FILE__).'/../../resources/'.$image_uname);
                    $image_open = Yii::app()->image->load(dirname(__FILE__).'/../../resources/'.$image_uname);
                    $image_open->resize(700, 700, Image::WIDTH);
                    $image_open->save();
                }

                if (isset($image_open)) {
                    if ($image_open->width > $image_open->height) $dim = Image::HEIGHT; else $dim = Image::WIDTH;
                    $image_open->resize(84, 84, $dim);
                    $image_open->save(dirname(__FILE__).'/../../resources/84_'.$image_uname);
                }

                if (isset($image_open)) {
                    $image_open->resize(60, 60, Image::HEIGHT);
                    $image_open->save(dirname(__FILE__).'/../../resources/60_'.$image_uname);
                }
                */

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
        //$old_image = $model->image;

        if(isset($_POST['ListOfferTypes']))
        {
            $model->attributes=$_POST['ListOfferTypes'];
            /*
            $model->image = $old_image;

            if (isset($_POST['image_delete'])) {
                if (is_file(dirname(__FILE__).'/../../resources/'.$model->image))
                    unlink(dirname(__FILE__).'/../../resources/'.$model->image);

                $model->image = NULL;
            }

            $image=CUploadedFile::getInstance($model,'image');
            if (isset($image)){
                $image_uname=substr(md5(uniqid(rand(), true)), 0, rand(7, 13)).'.'.$image->extensionName;
                $model->image = $image_uname;

                if (is_file(dirname(__FILE__).'/../../resources/'.$old_image))
                    unlink(dirname(__FILE__).'/../../resources/'.$old_image);
            }*/

            if ($model->save()) {              
                /*
                if (isset($image)) {
                    $image->saveAs(dirname(__FILE__).'/../../resources/'.$image_uname);
                    $image_open = Yii::app()->image->load(dirname(__FILE__).'/../../resources/'.$image_uname);
                    $image_open->resize(700, 700, Image::WIDTH);
                    $image_open->save();
                }

                if (isset($image_open)) {
                    if ($image_open->width > $image_open->height) $dim = Image::HEIGHT; else $dim = Image::WIDTH;
                    $image_open->resize(84, 84, $dim);
                    $image_open->save(dirname(__FILE__).'/../../resources/84_'.$image_uname);
                }

                if (isset($image_open)) {
                    $image_open->resize(60, 60, Image::HEIGHT);
                    $image_open->save(dirname(__FILE__).'/../../resources/60_'.$image_uname);
                }
                */

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

        $model=new ListOfferTypes('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ListOfferTypes']))
            $model->attributes=$_GET['ListOfferTypes'];

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
	 * @return ListOfferTypes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ListOfferTypes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ListOfferTypes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='list-offer-types-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Saves AJAX data for column order
	 * @return none
	 */
	public function actionSetOrder()
	{
		if(isset($_POST['item']) && is_numeric($_POST['item']))
		{
            $model = $this->loadModel($_POST['item']);
            if (!empty($model)) {
                $model->order = $_POST['value'];
                echo $model->save();
            }

            Yii::app()->end();
		}
	}
}
