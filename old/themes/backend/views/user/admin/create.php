<?php
/* @var $this AdminController */
/* @var $model User */

    $this->breadcrumbs=array(
        'Пользователи'=>array('admin'),
        'Добавление пользователя'
    );

    $this->pageTitle = 'Добавление пользователя — '.Yii::app()->name;

    $this->title = 'Пользователи';

?>


<div class="tabs-container">
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Добавление пользователя</h3>
                <br />
                <?php echo $this->renderPartial('_form', array('model'=>$model, 'profile'=>$profile)); ?>
            </div>
        </div>
    </div>
</div>