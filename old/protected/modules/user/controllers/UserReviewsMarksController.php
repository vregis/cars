<?php

class UserReviewsMarksController extends Controller
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
				'actions'=>array('mark'),
				'users'=>array('@'),
			),
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
	 * Save to favourites
	 * @return JSON
	 */
	public function actionMark()
	{
        if (isset($_POST['id'])) {
            $review = UserReviews::model()->findByPk($_POST['id']);
            if (!empty($review)) {
                $exist = UserReviewsMarks::model()->findByAttributes(array(
                    'author_id' => Yii::app()->user->id,
                    'review_id' => $_POST['id']
                ));
                
                if (empty($exist)) {
                    $model = new UserReviewsMarks;
                    $model->author_id = Yii::app()->user->id;
                    $model->review_id = $_POST['id'];
                    $model->save();
                } else {
                    $exist->delete();
                }
                
                echo count($review->marks);
            }
        }

        Yii::app()->end();
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $model = $this->loadModel($id);
        $review_id = $model->review_id;

        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'id'=>$review_id));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id)
	{   
        Yii::app()->theme = 'backend';

        $model=new UserReviewsMarks('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['UserReviewsMarks']))
            $model->attributes=$_GET['UserReviewsMarks'];
        $model->review_id = $id;

        if (isset($_GET['ajax'])) {
            $this->renderPartial('admingrid',array(
                'model'=>$model,
            ));
        }
        else {
            $form_model = new UserReviewsMarks;
            $form_model->review_id = $id;

            if(isset($_POST['UserReviewsMarks']))
            {
                $form_model->attributes = $_POST['UserReviewsMarks'];

                if ($form_model->save()) {
                    $this->redirect(array('admin', 'id'=>$id));
                }
            }

            $this->render('admin',array(
                'form_model'=>$form_model,
                'model'=>$model,
            ));
        }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return UserReviewsMarks the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=UserReviewsMarks::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param UserReviewsMarks $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-reviews-marks-form')
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
