<?php
/* @var $this AdminController */
/* @var $model User */

    $this->breadcrumbs=array(
        'Управление пользователями',
    );

    $this->pageTitle = 'Управление пользователями — '.Yii::app()->name;

    $this->title = 'Пользователи';
?>


<div class="tabs-container">
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Управление пользователями</h3>
                <br />
                <?php
                    echo '<p class="text-right">'.CHtml::link('+ Добавить пользователя', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
                    $this->renderPartial('admingrid', array('model'=>$model));
                ?>
            </div>
        </div>
    </div>
</div>