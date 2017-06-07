<?php

    $this->breadcrumbs=array(
        'Управление полями профиля'
    );

    $this->pageTitle = 'Управление полями профиля — '.Yii::app()->name;

    $this->title = 'Пользователи';
    
?>


<div class="tabs-container">
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Управление полями профиля</h3>
                <br />
                <?php
                    echo '<p class="text-right">'.CHtml::link('+ Добавить поле', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
                    $this->renderPartial('admingrid', array('dataProvider'=>$dataProvider));
                ?>
            </div>
        </div>
    </div>
</div>