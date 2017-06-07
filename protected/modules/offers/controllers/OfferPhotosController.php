<?php

class OfferPhotosController extends Controller
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
				'actions'=>array('index','delete','setOrder','setFullOrder'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('admin','setOrder','setFullOrder'),
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
        
        $model=new OfferPhotos('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['OfferPhotos']))
            $model->attributes=$_GET['OfferPhotos'];
        $model->offer_id = $id;
        
        if ($model->offer->owner_id != Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');

        if (isset($_GET['ajax'])) {
            $this->renderPartial('indexgrid',array(
                'model'=>$model,
            ));
        }
        else {
            $form_model = new OfferPhotos;
            $form_model->offer_id = $id;

            if ($model->offer->owner_id != Yii::app()->user->id)
                throw new CHttpException(404,'The requested page does not exist.');

            if (isset($_POST['OfferPhotos']))
            {
                $r = true;
                $image = CUploadedFile::getInstance($form_model,'filename');

                if (!empty($image)) {
                    $form_model=new OfferPhotos;
                    $form_model->instance = $image;
                    $form_model->offer_id = $id;

                    if ($form_model->save()) {
                        //if (isset($_GET['master'])) 
                            $this->redirect(array('/offers/offerPhotos/index', 'id'=>$model->offer_id));
                        //else
                        //    $this->redirect(array('index', 'id'=>$id));
                    }
                }                
            } elseif (!empty($_POST))
                $this->redirect(array('/offers/offerOptions/index', 'id'=>$model->offer_id));

            $this->render('index',array(
                'model'=>$model,
                'form_model'=>$form_model
            ));
        }
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
                
        if (!Yii::app()->user->isAdmin() && !(Yii::app()->user->id == $model->offer->owner_id))
            return false;  

        $model->delete();
        
        if (Yii::app()->user->isAdmin())
            $return_manual = array('admin', 'id' => $offer_id);
        else
            $return_manual = array('index', 'id' => $offer_id);        

        if(!isset($_GET['ajax']))             
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $return_manual);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id)
	{   
        Yii::app()->theme = 'backend';
        
        $model=new OfferPhotos('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['OfferPhotos']))
            $model->attributes=$_GET['OfferPhotos'];
        $model->offer_id = $id;

        if (isset($_GET['ajax'])) {
            $this->renderPartial('admingrid',array(
                'model'=>$model,
            ));
        }
        else {
            $form_model = new OfferPhotos;
            $form_model->offer_id = $id;

            if(isset($_POST['OfferPhotos']))
            {
                $r = true;
                $images = CUploadedFile::getInstances($form_model,'filename');

                if (!empty($images)) {
                    foreach ($images as $key => $image) {
                        $form_model=new OfferPhotos;
                        $form_model->instance = $image;
                        $form_model->offer_id = $id;
                        $t = $form_model->save();
                        if (!$t) {
                            CVarDumper::dump($form_model->errors, 10, true);
                        }
                        $r = $r * $t;
                    }

                    if ($r)
                        $this->redirect(array('admin', 'id'=>$id));
                }                
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
	 * @return OfferPhotos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OfferPhotos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OfferPhotos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='offer-photos-form')
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

	/**
	 * Saves AJAX data for columns order
	 * @return none
	 */
	public function actionSetFullOrder()
	{
		if(isset($_POST['order']) && is_array($_POST['order']) && !empty($_POST['order']))
		{
            $order = 0;
            foreach ($_POST['order'] as $id) {
                $model = OfferPhotos::model()->findByPk($id);
                if (empty($model)) continue;
                $model->order = $order;
                $model->save();
                
                $order += 10;
            }
            
            echo 1;
            Yii::app()->end();
		}
	}
}
