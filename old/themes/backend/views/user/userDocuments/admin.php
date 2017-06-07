<?php
    /* @var $this UserDocumentsController */
    /* @var $model UserDocuments */

    $this->breadcrumbs=array(
        'Управление пользователями'=>array('/user/admin/admin'),
        $model->user->profile->name=>array('/user/admin/update', 'id'=>$model->user_id),
        'Управление документами'
    );

    $this->pageTitle = 'Управление документами — '.Yii::app()->name;

    $this->title = 'Пользователи';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/admin/_tabs', array('model'=>$model->user)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Управление документами</h3>
                <br />
                <?php
                    echo '<p class="text-right">'.CHtml::link('+ Добавить документ', array('create', 'id'=>$model->user_id), array('class'=>'btn btn-primary text-right')).'</p>';
            
                    $this->renderPartial('admingrid', array('model'=>$model));
                ?>
            </div>
        </div>
    </div>
</div>