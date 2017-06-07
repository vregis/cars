<?php
    /* @var $this ListProvincesController */
    /* @var $model ListProvinces */

    $this->breadcrumbs=array(
        'Управление странами'=>array('/listCountries/admin'),
        'Редактирование страны «'.$model->country->name.'»'=>array('/listCountries/update', 'id' => $model->country_id),
        'Управление провинциями',
    );

    $this->pageTitle = 'Управление провинциями — '.Yii::app()->name;

    $this->title = 'Управление провинциями';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление провинциями</h5>
        
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
            echo '<p class="text-right">'.CHtml::link('+ Добавить провинцию', array('create', 'id' => $model->country_id), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>