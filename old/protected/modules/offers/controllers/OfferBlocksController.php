<?php

class OfferBlocksController extends Controller
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
				'actions'=>array('add','edit','index','delete','daySchedule'),
				'users'=>array('@'),
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

    
    
	public function actionDaySchedule($offer_id, $date)
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $offer = Offers::model()->findByPk($offer_id);        
        if ($offer->owner_id != Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');
        
        $blocks = OfferBlocks::model()->findAllByAttributes(array('offer_id' => $offer_id));
        
        $this->renderPartial('_day', array('blocks' => $blocks, 'date' => $date));
        
        return true;
	}

    
    
	public function actionAdd($id, $since, $for)
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model=new OfferBlocks;
        $model->offer_id = $id;
        
        if ($model->offer->owner_id != Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');

        if(!empty($since) && !empty($for))
        {
            $model->date_since = $since.':00';
            $model->date_for = $for.':00';

            return $model->save();            
        }

        return false;
	}
    
    
    
	public function actionEdit($id)
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model=$this->loadModel($id);
        
        if ($model->offer->owner_id != Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');

        if(isset($_POST['OfferBlocks']))
        {
            $model->attributes=$_POST['OfferBlocks'];

            if ($model->save()) {
                $this->redirect(array('index', 'id' => $model->offer_id));
            }
        }

        $this->render('edit',array(
            'model'=>$model,
        ));
	}
    
    
    
	public function actionIndex($id)
	{   
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $offer = Offers::model()->findByPk($id);        
        if ($offer->owner_id != Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');

        if (isset($_GET['s'])) {
            $date_since = new DateTime($_GET['s']);
            $date_for = new DateTime($_GET['s']);
            $date_for = $date_for->add(new DateInterval('P2M'))->sub(new DateInterval('P1D'));
        } else {
            $date_since = new DateTime(date('Y-m-01'));
            $date_for = new DateTime(date('Y-m-01'));
            $date_for = $date_for->add(new DateInterval('P2M'))->sub(new DateInterval('P1D'));
        }
        
        $blocks = OfferBlocks::model()->findAllByAttributes(array('offer_id' => $id));
        if (!empty($blocks))
            foreach ($blocks as $key => $block) {
                $block_since = new DateTime($block->date_since);
                $block_for = new DateTime($block->date_for);
                if (
                    $block_since > $date_for ||
                    $block_for < $date_since
                )
                    unset($blocks[$key]);
            }
        
        $this->render('index',array(
            'offer'=>$offer,
            'blocks'=>$blocks,
            'date_since'=>$date_since,
            'date_for'=>$date_for,
        ));
	}
    
    
    

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
        Yii::app()->theme = 'backend';

        $model=new OfferBlocks;
        $model->offer_id = $id;

        if(isset($_POST['OfferBlocks']))
        {
            $model->attributes=$_POST['OfferBlocks'];

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

        if(isset($_POST['OfferBlocks']))
        {
            $model->attributes=$_POST['OfferBlocks'];

            if ($model->save()) {
                $this->redirect(array('admin', 'id' => $model->offer_id));
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

        $model=new OfferBlocks('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['OfferBlocks']))
            $model->attributes=$_GET['OfferBlocks'];
        $model->offer_id = $id;

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
	 * @return OfferBlocks the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OfferBlocks::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OfferBlocks $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='offer-documents-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
