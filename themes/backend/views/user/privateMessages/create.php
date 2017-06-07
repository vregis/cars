<?php
/* @var $this PrivateMessagesController */
/* @var $model PrivateMessages */

    $this->breadcrumbs=array(
        'Управление сообщениями'=>array('admin'),
        'Добавление сообщения',
    );

    $this->pageTitle = 'Добавление сообщения — '.Yii::app()->name;

    $this->title = 'Управление сообщениями';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление сообщения</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


