<?php
/* @var $this ParametersController */
/* @var $model Parameters */

    $this->breadcrumbs=array(
        'Управление параметрами',
    );

    $this->pageTitle = 'Управление параметрами — '.Yii::app()->name;

    $this->title = 'Параметры';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление параметрами</h5>
        
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
            echo '<p class="text-right">'.CHtml::link('+ Добавить параметр', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>