<?php

class ParametersCategoriesController extends Controller
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
				'actions'=>array('admin','delete'),
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
        $category_id = $model->category_id;

        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'id'=>$category_id));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id)
	{   
        Yii::app()->theme = 'backend';

        $parameters = Parameters::model()->findAll(array('order'=>'`order` ASC'));
        $parameters_1 = array();
        $parameters_2 = array();
        $parameters_3 = array();
        $i = 0;
        if (!empty($parameters))
            foreach ($parameters as $parameter) {
                if ($i % 3 == 0)
                    $parameters_1[] = $parameter;
                elseif ($i % 3 == 1)
                    $parameters_2[] = $parameter;
                else
                    $parameters_3[] = $parameter;

                $i++;
            }

            
            
        $category = Categories::model()->findByPk($id);
            
        if (isset($_POST['parameters'])) {
            if (!empty($category->parameters_categories))
                foreach ($category->parameters_categories as $pc) {
                    $pc->delete();
                }
            
            foreach ($_POST['parameters'] as $parameter_id) {
                $pc = new ParametersCategories;
                $pc->parameter_id = $parameter_id;
                $pc->category_id = $id;
                $pc->save();
            }
            
            $this->redirect(array('/parametersCategories/admin', 'id'=>$id));
        }

        
        
        $selected_parameters_array = $category->parameters;
        $selected_parameters = array();
        if (!empty($selected_parameters_array))
            foreach ($selected_parameters_array as $parameter) {
                $selected_parameters[] = $parameter->id;
            }

        $this->render('admin',array(
            'parameters_1'=>$parameters_1,
            'parameters_2'=>$parameters_2,
            'parameters_3'=>$parameters_3,
            'selected_parameters'=>$selected_parameters,
            'category'=>$category,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ParametersCategories the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ParametersCategories::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ParametersCategories $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='parameters-categories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
