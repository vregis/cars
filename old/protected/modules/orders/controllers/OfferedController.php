<?php

class OfferedController extends Controller
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
				'actions'=>array('index','view','edit','delete'),
				'users'=>array('@'),
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
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = $this->loadModel($id);

        if ($model->status < Orders::STATUS_PAYMENT && isset($_POST['Orders']))
        {
            $model->notes = $_POST['Orders']['notes'];
            $model->discount = $_POST['Orders']['discount'];
            
            $model->status = Orders::STATUS_NEW;

            if ($model->save()) {                  
                $this->redirect(array('view', 'id' => $id));
            }
        }

        if ($model->status == Orders::STATUS_APPROVED && isset($_POST['release_code']) && ($_POST['release_code'] == $model->release_code))
        {            
            $model->status = Orders::STATUS_SUCCESSFUL;

            if ($model->save()) {
                $payment = new Payments;
                $payment->order_id = $model->id;
                $payment->client_id = $model->offer->owner_id;
                $payment->payment_type = 1;
                $payment->type = Payments::TYPE_REFILL;
                $payment->amount = $model->total_cost;
                $payment->payer_name = 'AutoPayment';
                $payment->is_approved = 1;
                $payment->approved_by = Yii::app()->params['bot']['id'];
                $payment->date_approved = date('Y-m-d H:i:s');
                $r = $payment->save();

                if (!$r) {
                    CVarDumper::dump($payment->errors, 10, true);
                    exit();
                }
                
                $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('view',array(
            'model'=>$model,
        ));
	}

    
    
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = new Orders('search');
        $model->unsetAttributes();
        
        $this->render('index',array(
            'model'=>$model,
        ));
	}
    
        
	public function actionEdit($id)
	{
        Yii::app()->theme = 'account';
        $this->layout='//layouts/account';
        
        $model = $this->loadModel($id);

        if(isset($_POST['Orders']))
        {
            $model->attributes = $_POST['Orders'];

            if ($model->save()) {
                if (!empty($model->orderedOptions))
                    foreach ($model->orderedOptions as $option) {
                        $option->delete();
                    }
                        
                if (isset($_POST['OfferOptions'])) {
                    foreach ($_POST['OfferOptions'] as $option_id) {
                        $option = new OrderedOptions;
                        $option->order_id = $model->id;
                        $option->option_id = $option_id;
                        $option->save();
                    }
                }
                  
                $this->redirect(array('view', 'id' => $id));
            }
        }
        
        $a_options_list = CHtml::listData($model->orderedOptions, 'option_id', 'option_id');
        $a_options = array_keys($a_options_list);

        $this->render('edit',array(
            'model'=>$model,
            'a_options'=>$a_options,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Orders the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Orders::model()->findByPk($id);
		if($model===null || $model->offer->owner_id != Yii::app()->user->id)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Orders $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='orders-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
