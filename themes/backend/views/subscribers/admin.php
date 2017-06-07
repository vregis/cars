<?php
    /* @var $this SubscribersController */
    /* @var $model Subscribers */

    $this->breadcrumbs=array(
        'Управление подписчиками',
    );

    $this->pageTitle = 'Управление подписчиками — '.Yii::app()->name;

    $this->title = 'Подписчики';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Новый подписчик</h5>
        
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
            $this->renderPartial('_form', array('model'=>$form_model));
        ?>
    </div>
</div>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление подписчиками</h5>
        
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

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Экспорт списка подписчиков</h5>
        
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
            echo CHtml::link('Формат CSV для MS Outlook', array('export', 'type' => 'csv'), array('class' => 'btn btn-info'));
        ?>
    </div>
</div>