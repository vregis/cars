<?php

class PrivateMessagesController extends Controller
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
				'actions'=>array('add', 'index', 'dialog', 'remove', 'dialogWindow', 'setSeen', 'ajaxList', 'getNewMessages', 'hide'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionIndex()
	{
        Yii::app()->theme = 'account';
        $this->layout = '//layouts/im';
        
        $contacts = PrivateMessages::getMyContacts();
        if (!empty($contacts))
            $first_contact = $contacts[0]['url']['id'];
        else
            $first_contact = NULL;

        $this->render('index',array(
            'first_contact' => $first_contact
        ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionDialog($id)
	{
        Yii::app()->theme = 'account';
        $this->layout = '//layouts/im';

        //New message
        $model=new PrivateMessages;
        $model->recepient_id = $id;
        
        if (isset($_POST['PrivateMessages'])) {
            $model->text = $_POST['PrivateMessages']['text'];
            $model->recepient_id = $id;
            $model->sender_id = Yii::app()->user->id;

            if ($model->save()) 
                $this->redirect(array('dialog', 'id'=>$id));
        }
        
        $this->render('dialog',array(
            'id' => $id
        ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionDialogWindow($id)
	{
        Yii::app()->theme = 'account';
        $this->layout = '//layouts/plain';
        
        $messages = PrivateMessages::getDialog($id);

        //New message
        $model=new PrivateMessages;
        $model->recepient_id = $id;
        
        $this->render('_dialog',array(
            'messages' => $messages,
            'model' => $model
        ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionRemove($id)
	{
        $model = $this->loadModel($id);

        if ($model->recepient_id == Yii::app()->user->id) {
            $model->setStatus(PrivateMessages::IM_STATUS_HIDDEN_R);
            $user_id = $model->sender_id;
        } elseif ($model->sender_id == Yii::app()->user->id) {
            $model->setStatus(PrivateMessages::IM_STATUS_HIDDEN_S);
            $user_id = $model->recepient_id;
        }

        $this->redirect(array('dialog', 'id' => $user_id));
	}
    
    
    
	public function actionAdd($id)
	{        
        $model = new PrivateMessages;
        $mail = User::model()->findByPk($id);
        UserModule::sendMail($mail->username, 'Notification', 'You have a new message on getupway.com');
        $model->recepient_id = $id;
        $model->sender_id = Yii::app()->user->id;
        $model->text = $_POST['text'];
        echo $model->save();
	}

    
    
	public function actionAjaxList($id)
	{
        Yii::app()->theme = 'account';
        $this->layout = '//layouts/im';
        
        $messages = PrivateMessages::getDialog($id);        
        $this->renderPartial('_messages_list', array('messages' => $messages));
	}

    
    
	public function actionGetNewMessages()
	{
        $all = PrivateMessages::countNew();
        $actual = PrivateMessages::countNew($_POST['id']);
        
        echo json_encode(array('all' => $all, 'actual' => $actual));
	}

    
    
	public function actionHide($id)
	{
        $messages = PrivateMessages::getDialog($id);
        
        if (!empty($messages))
            foreach ($messages as $message) {
                if ($message->sender_id == Yii::app()->user->id)
                    $message->setStatus(PrivateMessages::IM_STATUS_HIDDEN_S);
                else
                    $message->setStatus(PrivateMessages::IM_STATUS_HIDDEN_R);
            }
        
        $this->redirect(array('/user/privateMessages/index'));
	}
    
    

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::app()->theme = 'account';

        $model=new PrivateMessages;

        if(isset($_POST['PrivateMessages']))
        {
            $model->attributes=$_POST['PrivateMessages'];

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

        if(isset($_POST['PrivateMessages']))
        {
            $model->attributes=$_POST['PrivateMessages'];

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

        $model=new PrivateMessages('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['PrivateMessages']))
            $model->attributes=$_GET['PrivateMessages'];

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
	 * @return PrivateMessages the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PrivateMessages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PrivateMessages $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='private-messages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Saves AJAX data for column order
	 * @return none
	 */
	public function actionSetSeen($id)
	{        
        $message = PrivateMessages::model()->findByAttributes(array('id' => $id, 'recepient_id' => Yii::app()->user->id));
        
        if (!empty($message)) {
            $message->is_seen = 1;
            echo $message->save();            
        }
        
        Yii::app()->end();
	}
}
