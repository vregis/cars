<?php

class OffersParameterValuesController extends Controller
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
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>Yii::app()->user->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    
	public function actionIndex($id)
	{   
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $offer = Offers::model()->findByPk($id);
        
        $parameters = $offer->category->allParameters;
        
        $errors = array();    
            
        if (!empty($parameters) && !empty($_POST)) {            
            foreach ($parameters as $parameter) {
                //echo 111;
                //exit();
                if (!isset($_POST['parameter-'.$parameter->id])) continue;
                
                $parameter_value = OffersParameterValues::model()->find(array(
                    'condition' => '`parameter_id` = :parameter_id AND `offer_id` = :offer_id',
                    'params' => array(':parameter_id' => $parameter->id, ':offer_id' => $id),
                ));
                
                if (empty($parameter_value)) {
                    $parameter_value = new OffersParameterValues;
                    $parameter_value->parameter_id = $parameter->id;
                    $parameter_value->offer_id = $id;                    
                }
                
                if (is_array($_POST['parameter-'.$parameter->id]))
                    $value = implode(', ', $_POST['parameter-'.$parameter->id]);
                elseif (!empty($_POST['parameter-'.$parameter->id]))
                    $value = $_POST['parameter-'.$parameter->id];
                else
                    $value = NULL;
                $parameter_value->parameter_value = $value;                    
                
                if ($value !== NULL)
                    $r = $parameter_value->save();
                else
                    $r = ((!$parameter_value->isNewRecord)?($parameter_value->delete()):(true));
                
                if (!$r) 
                    $errors[$parameter->id] = implode(' ', $parameter_value->errors['parameter_value']);
                
            }
            
            if (isset($_GET['master']) || ($offer->status == Offers::STATUS_PASSIVE)) 
                $this->redirect(array('/offers/offerPhotos/index', 'id'=>$offer->id, 'master' => 'go'));
        } elseif (empty($parameters) && !empty($_POST))
            $this->redirect(array('/offers/offerPhotos/index', 'id'=>$offer->id));

        $this->render('index',array(
            'parameters'=>$parameters,
            'groupedParameters'=>Parameters::groupList($parameters),
            'offer'=>$offer,
            'errors'=>$errors,
        ));
	}
    
    

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id)
	{   
        Yii::app()->theme = 'backend';
        $offer = Offers::model()->findByPk($id);
        
        $parameters = $offer->category->parameters;
        
        $errors = array();    
            
        if (!empty($parameters)) {            
            foreach ($parameters as $parameter) {
                if (!isset($_POST['parameter-'.$parameter->id])) continue;
                
                $parameter_value = OffersParameterValues::model()->find(array(
                    'condition' => '`parameter_id` = :parameter_id AND `offer_id` = :offer_id',
                    'params' => array(':parameter_id' => $parameter->id, ':offer_id' => $id),
                ));
                
                if (empty($parameter_value)) {
                    $parameter_value = new OffersParameterValues;
                    $parameter_value->parameter_id = $parameter->id;
                    $parameter_value->offer_id = $id;                    
                }
                
                if (is_array($_POST['parameter-'.$parameter->id]))
                    $value = implode(', ', $_POST['parameter-'.$parameter->id]);
                elseif (!empty($_POST['parameter-'.$parameter->id]))
                    $value = $_POST['parameter-'.$parameter->id];
                else
                    $value = NULL;
                $parameter_value->parameter_value = $value;                    
                
                if ($value !== NULL)
                    $r = $parameter_value->save();
                elseif (!$parameter_value->isNewRecord)
                    $r = $parameter_value->delete();
                
                if (!$r) 
                    $errors[$parameter->id] = implode(' ', $parameter_value->errors['parameter_value']);
            }
        }

        $this->render('admin',array(
            'parameters'=>$parameters,
            'offer'=>$offer,
            'errors'=>$errors,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OffersParameterValues the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OffersParameterValues::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OffersParameterValues $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='parameter-values-offers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
