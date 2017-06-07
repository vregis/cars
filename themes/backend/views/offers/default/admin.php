<?php
    /* @var $this OffersController */
    /* @var $model Offers */

    $this->breadcrumbs=array(
        'Управление предложениями',
    );

    $this->pageTitle = 'Управление предложениями — '.Yii::app()->name;

    $this->title = 'Предложения';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление предложениями</h5>
        
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
            echo '<p class="text-right">'.CHtml::link('+ Добавить предложение', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>