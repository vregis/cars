<?php
    /* @var $this UserReviewsMarksController */
    /* @var $model UserReviewsMarks */

    $this->breadcrumbs=array(
        'Управление пользователями'=>array('/user/admin/admin'),
        $model->review->user->profile->name=>array('/user/admin/update', 'id'=>$model->review->user_id),
        'Управление отзывами'=>array('/user/userReviews/admin', 'id'=>$model->review->user_id),
        'Редактирование отзыва #'.$model->id=>array('/user/userReviews/update', 'id'=>$model->review_id),
        'Управление оценками'
    );

    $this->pageTitle = 'Управление оценками — '.Yii::app()->name;

    $this->title = 'Пользователи';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/admin/_tabs', array('model'=>$model->review->user)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Управление оценками</h3>
                <br />
                <?php
                    $this->renderPartial('admingrid', array('model'=>$model));
                ?>
            </div>
        </div>
    </div>
</div>