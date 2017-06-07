<?php

class SiteVarsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','setWysiwyg'),
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
	public function actionCreate()
	{             
        Yii::app()->theme = 'backend';
               
		$model=new SiteVars;

		if(isset($_POST['SiteVars']))
		{
			$model->attributes=$_POST['SiteVars'];

            if ($model->field_type == 3) {
                $file = CUploadedFile::getInstance($model,'value');
                if (isset($file)){
                    $file_uname=date('YmdHis').'_'.substr(md5(uniqid(rand(), true)), 0, rand(7, 13)).'.'.$file->extensionName;
                    $model->value = $file_uname;
                }
            }
                    
            if ($model->save()) {
                if (isset($file))
                    $file->saveAs(dirname(__FILE__).'/../../../../resources/vars/'.$file_uname);
                    
                $this->redirect(array('admin'));
            }
		}
                
                
                
        //Rendering results
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
        $old_file = $model->value;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SiteVars']))
		{
			$model->attributes=$_POST['SiteVars'];

            if ($model->field_type == 3) {
                $model->value = $old_file;
                
                $file = CUploadedFile::getInstance($model,'value');
                if (isset($file)){
                    $file_uname=date('YmdHis').'_'.substr(md5(uniqid(rand(), true)), 0, rand(7, 13)).'.'.$file->extensionName;
                    $model->value = $file_uname;

                    if (is_file(dirname(__FILE__).'/../../../../resources/vars/'.$old_file))
                        unlink(dirname(__FILE__).'/../../../../resources/vars/'.$old_file);
                }
            }

            if ($model->save()) {
                if (isset($file))
                    $file->saveAs(dirname(__FILE__).'/../../../../resources/vars/'.$file_uname);
                
                $this->redirect(array('admin'));
            }
		}                
                
                
        //Rendering results
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
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{         
        Yii::app()->theme = 'backend';

            $model=new SiteVars('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['SiteVars']))
                $model->attributes=$_GET['SiteVars'];

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
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=SiteVars::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='posts-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Saves AJAX data for column wysiwyg_on
	 * @return none
	 */
	public function actionSetWysiwyg()
	{
		if(isset($_POST['item']) && is_numeric($_POST['item']))
		{
            $model = $this->loadModel($_POST['item']);
            if (!empty($model)) {
                $model->wysiwyg_on = $_POST['checked'];
                echo $model->save();
            }

            Yii::app()->end();
		}
	}
}
