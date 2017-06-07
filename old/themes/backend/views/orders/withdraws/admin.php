<?php
    /* @var $this WithdrawsController */
    /* @var $model Withdraws */

    $this->breadcrumbs=array(
        'Управление заявками',
    );

    $this->pageTitle = 'Управление заявками — '.Yii::app()->name;

    $this->title = 'Заявки на вывод средств';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление заявками</h5>
        
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
            echo '<p class="text-right">'.CHtml::link('+ Добавить заявку', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>