<?php
/* @var $this NotificationsController */
/* @var $model Notifications */

    $this->breadcrumbs=array(
        'Управление уведомлениями',
    );

    $this->pageTitle = 'Управление уведомлениями — '.Yii::app()->name;

    $this->title = 'Уведомления';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление уведомлениями</h5>
        
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="close-link">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
        <?php            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>