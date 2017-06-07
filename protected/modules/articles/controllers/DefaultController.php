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
				'actions'=>array('index','featured','view'),
				'users'=>array('*'),
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($url_name)
	{
        $this->layout='//layouts/one_column';

        $model = Articles::model()->findByAttributes(array(
            'url_name' => $url_name
        ));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
        
        $model->views += 1;
        $model->save();

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

        $articles_ground = Articles::model()->findAll(array(
            'condition' => '`visible` = 1 AND `date_created` < NOW() AND `category_id` = 0',
            'order' => '`date_created` DESC',
        ));

        $articles_water = Articles::model()->findAll(array(
            'condition' => '`visible` = 1 AND `date_created` < NOW() AND `category_id` = 1',
            'order' => '`date_created` DESC',
        ));

        $articles_air = Articles::model()->findAll(array(
            'condition' => '`visible` = 1 AND `date_created` < NOW() AND `category_id` = 2',
            'order' => '`date_created` DESC',
        ));
        
        $this->render('index',array(
            'articles_ground'=>$articles_ground,
            'articles_water'=>$articles_water,
            'articles_air'=>$articles_air,
        ));
	}

	/**
	 * Lists all models.
	 */
	public function actionFeatured($id)
	{
        $this->layout='//layouts/one_column';
        
        switch ($id) {
            case 'ground': $category_id = 0; break;
            case 'water': $category_id = 1; break;
            case 'air': $category_id = 2; break;
            default: $category_id = 0; break;
        }

        $articles = Articles::model()->findAll(array(
            'condition' => '`visible` = 1 AND `date_created` < NOW() AND `category_id` = :id',
            'params' => array(':id' => $category_id),
            'order' => '`views` DESC',
            'limit' => 20,
        ));
        
        shuffle($articles);
        if (count($articles) > 10)
            foreach ($articles as $key => $article) {
                if ($key >= 10) unset($articles[$key]);
            }        
        
        $this->render('featured',array(
            'articles'=>$articles,
            'id' => $id
        ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::app()->theme = 'backend';

        $model=new Articles;

        if(isset($_POST['Articles']))
        {
            $model->attributes=$_POST['Articles'];

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

        if(isset($_POST['Articles']))
        {
            $model->attributes=$_POST['Articles'];

            if (isset($_POST['image_delete'])){
                $model->removeImages('image');
                $model->image = NULL;
            }

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

        $model=new Articles('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Articles']))
            $model->attributes=$_GET['Articles'];

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
	 * @return Articles the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Articles::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Articles $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='articles-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
