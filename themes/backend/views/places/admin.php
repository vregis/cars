<?php
    /* @var $this PlacesController */
    /* @var $model Places */

    $this->breadcrumbs=array(
        'Управление POI',
    );

    $this->pageTitle = 'Управление POI — '.Yii::app()->name;

    $this->title = 'Управление POI';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление POI</h5>
        
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
            echo '<p class="text-right">'.CHtml::link('+ Добавить POI', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>