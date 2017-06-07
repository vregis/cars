<?php

    $this->breadcrumbs=array(
        'Управление полями профиля'=>array('admin'),
        $model->title
    );

    $this->pageTitle = $model->title.' — '.Yii::app()->name;

    $this->title = 'Пользователи';
    
?>


<div class="tabs-container">
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>