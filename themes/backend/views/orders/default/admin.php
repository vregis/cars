<?php
    /* @var $this OrdersController */
    /* @var $model Orders */

    $this->breadcrumbs=array(
        'Управление заказами',
    );

    $this->pageTitle = 'Управление заказами — '.Yii::app()->name;

    $this->title = 'Управление заказами';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление заказами</h5>
        
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
            echo '<p class="text-right">'.CHtml::link('+ Добавить заказ', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>