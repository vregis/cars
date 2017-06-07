<?php
/* @var $this UserReviewsController */
/* @var $model UserReviews */

    $this->breadcrumbs=array(
        'Управление пользователями'=>array('/user/admin/admin'),
        $model->user->profile->name=>array('/user/admin/update', 'id'=>$model->user_id),
        'Управление отзывами'=>array('/user/userReviews/admin', 'id'=>$model->user_id),
        'Отзыв по заказу #'.$model->order_id,
    );

    $this->pageTitle = 'Отзыв по заказу #'.$model->order_id.' — '.Yii::app()->name;

    $this->title = 'Пользователи';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/admin/_tabs', array('model'=>$model->user)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Отзыв по заказу #<?php echo $model->order_id; ?></h3>
                <br />
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>