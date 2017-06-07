<?php

class ClientsController extends Controller
{
	public $defaultAction = 'admin';
	
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
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
				'actions'=>array('admin','delete','create','update','getData'),
				'users'=>Yii::app()->user->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            Yii::app()->theme = 'backend';
            
            $this->layout='//layouts/main';
            
            $model=new Profile('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Profile']))
                $model->attributes=$_GET['Profile'];

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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::app()->theme = 'backend';

        $this->layout='//layouts/main';
                
		$model=new User;
        $model->superuser = 0;
        $model->status = 0;
		$profile=new Profile;
        $address = new AddressForm;
                
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
            $address->attributes=$_POST['AddressForm'];
            $model->username = $_POST['User']['username'];
            $model->email = $_POST['User']['email'];
                                        
			$password=strtoupper(substr(UserModule::encrypting(microtime()), 0, 5));
            $model->password=$password;
			$model->activkey=strtoupper(substr(microtime()*1000000, 0, 5));
			$model->createtime=time();
			$model->lastvisit=time();
			$model->status = 1;
			$model->superuser=0;
			$model->social_identity = Yii::app()->user->id;
			$profile->attributes=$_POST['Profile'];
			$profile->user_id=0;
				
            if ($address->validate()) 
                $profile->address = $address->group();
				
			if (!empty($profile->date_birth)) 
				$profile->date_birth = Yii::app()->locale->dateFormatter->format('yyyy-MM-dd', $profile->date_birth);
                        
			if($model->validate()&&$profile->validate()) {
				$model->password=Yii::app()->controller->module->encrypting($model->password);
                
				if($model->save()) {                                    
					$profile->user_id=$model->id;
					$profile->save();
				}
                
                UserModule::sendSms($model, $password);
                
				$this->redirect(array('checkPhone', 'id'=>$model->id));
			} else $profile->validate();
		}
				
		if (!empty($profile->date_birth)) 
			$profile->date_birth = Yii::app()->locale->dateFormatter->format('dd-MM-yyyy', $profile->date_birth);

		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
			'address'=>$address,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
        Yii::app()->theme = 'backend';

        $this->layout='//layouts/main';
                                
		$model=$this->loadModel();
		$profile=$model->profile;
        $old_image = $profile->photo;
                
		if(isset($_POST['User']))
		{
            $image=CUploadedFile::getInstance($profile,'photo');
            unset($_POST['Profile']['photo']);
			$model->attributes=$_POST['User'];
            $model->username = $_POST['User']['username'];
			//$model->status=$_POST['User']['status'];
			$profile->attributes=$_POST['Profile'];
            $profile->photo = $old_image;
				
			if (!empty($profile->date_birth)) 
				$profile->date_birth = Yii::app()->locale->dateFormatter->format('yyyy-MM-dd', $profile->date_birth);
                    
            if (isset($image)){
                $uname=substr(md5(uniqid(rand(), true)), 0, rand(7, 13)).'.'.$image->extensionName;
                $profile->photo = $uname;

                if (is_file(dirname(__FILE__).'/../../../../resources/users/'.$old_image))
                    unlink(dirname(__FILE__).'/../../../../resources/users/'.$old_image);

                if (is_file(dirname(__FILE__).'/../../../../resources/users/48_'.$old_image))
                    unlink(dirname(__FILE__).'/../../../../resources/users/48_'.$old_image);
            }
			
			if($model->validate()&&$profile->validate()) {
				$old_password = User::model()->notsafe()->findByPk($model->id);
				if ($old_password->password!=$model->password) {
					$model->password=Yii::app()->controller->module->encrypting($model->password);
					$model->activkey=strtoupper(substr(microtime()*1000000, 0, 5));
				}
                
                if (isset($_POST['photo_delete'])) {
                    if (is_file(dirname(__FILE__).'/../../../../resources/users/'.$old_image))
                        unlink(dirname(__FILE__).'/../../../../resources/users/'.$old_image);

                    if (is_file(dirname(__FILE__).'/../../../../resources/users/48_'.$old_image))
                        unlink(dirname(__FILE__).'/../../../../resources/users/48_'.$old_image);

                    $profile->photo = NULL;
                }

                if (isset($image)) {                                    
                    $image->saveAs(dirname(__FILE__).'/../../../../resources/users/'.$uname);
                    $image_open = Yii::app()->image->load(dirname(__FILE__).'/../../../../resources/users/'.$uname);
                    $image_open->resize(200, 200,Image::WIDTH);
                    $image_open->save();

                    if (isset($image_open)) {
                        if ($image_open->width > $image_open->height)
                            $dim = Image::HEIGHT;
                        else
                            $dim = Image::WIDTH;
                        $image_open->resize(48, 48, $dim)->crop(48, 48);
                        $image_open->save(dirname(__FILE__).'/../../../../resources/users/48_'.$uname);
                    }
                }
                                
				$model->save();
				$profile->save();
				$this->redirect(array('admin'));
			} else $profile->validate();
		}
				
		if (!empty($profile->date_birth)) 
			$profile->date_birth = Yii::app()->locale->dateFormatter->format('dd-MM-yyyy', $profile->date_birth);

		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$profile = Profile::model()->findByPk($model->id);
                        
            if ($model->id != 1) {
                if (is_file(dirname(__FILE__).'/../../../../resources/users/'.$profile->photo))
                    unlink(dirname(__FILE__).'/../../../../resources/users/'.$profile->photo);

                if (is_file(dirname(__FILE__).'/../../../../resources/users/48_'.$profile->photo))
                    unlink(dirname(__FILE__).'/../../../../resources/users/48_'.$profile->photo);

                $profile->delete();
                $model->delete();
            }
            
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('/user/admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

    
	/**
	 * Return getListData array for AJAX
	 * @return JSON
	 */
	public function actionGetData($q)
	{
		$raw_data = Profile::model()->findAll(array(
            'condition' => '(`firstname` LIKE :q OR `lastname` LIKE :q) AND `user`.superuser = 0',
            'params' => array(':q' => '%'.$q.'%'),
            'with' => array('user'),
        ));
        $data_list = CHtml::listData($raw_data, 'user_id', function($data) {return $data->name;});
        
        $data = array();
        if (!empty($data_list))
            foreach ($data_list as $key => $value) {
                $data[] = array('id' => $key, 'text' => $value);
            }
        
        echo json_encode($data);

        Yii::app()->end();
	}
}