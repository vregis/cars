<?php

    $this->breadcrumbs=array(
        'Управление полями профиля'=>array('admin'),
        'Добавление поля'
    );

    $this->pageTitle = 'Добавление поля — '.Yii::app()->name;

    $this->title = 'Пользователи';
    
?>


<div class="tabs-container">
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Добавление поля</h3>
                <br />
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>