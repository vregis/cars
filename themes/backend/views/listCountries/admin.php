<?php
    /* @var $this ListCountriesController */
    /* @var $model ListCountries */

    $this->breadcrumbs=array(
        'Управление странами',
    );

    $this->pageTitle = 'Управление странами — '.Yii::app()->name;

    $this->title = 'Управление странами';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление странами</h5>
        
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
            echo '<p class="text-right">'.CHtml::link('+ Добавить страну', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>