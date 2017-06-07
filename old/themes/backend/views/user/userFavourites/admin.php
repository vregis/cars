<?php
    /* @var $this UserFavouritesController */
    /* @var $model UserFavourites */

    $this->breadcrumbs=array(
        'Управление пользователями'=>array('/user/admin/admin'),
        $model->user->profile->name=>array('/user/admin/update', 'id'=>$model->user_id),
        'Управление избранным'
    );

    $this->pageTitle = 'Управление избранным — '.Yii::app()->name;

    $this->title = 'Пользователи';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/admin/_tabs', array('model'=>$model->user)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Добавить в избранное</h3>
                <br />
                <?php echo $this->renderPartial('_form', array('model'=>$form_model)); ?>
                <hr class="hr-line-dashed" />
                <h3>Управление избранным</h3>
                <br />
                <?php $this->renderPartial('admingrid', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>