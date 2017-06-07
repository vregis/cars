<?php
    /* @var $this UserReviewsController */
    /* @var $model UserReviews */

    $this->breadcrumbs=array(
        'Управление пользователями'=>array('/user/admin/admin'),
        $model->user->profile->name=>array('/user/admin/update', 'id'=>$model->user_id),
        'Управление отзывами'
    );

    $this->pageTitle = 'Управление отзывами — '.Yii::app()->name;

    $this->title = 'Пользователи';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/admin/_tabs', array('model'=>$model->user)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Управление отзывами</h3>
                <br />
                <?php
                    $this->renderPartial('admingrid', array('model'=>$model));
                ?>
            </div>
        </div>
    </div>
</div>