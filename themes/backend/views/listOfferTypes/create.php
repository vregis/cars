<?php
/* @var $this ListOfferTypesController */
/* @var $model ListOfferTypes */

    $this->breadcrumbs=array(
        'Управление типами предложений'=>array('admin'),
        'Добавление типа',
    );

    $this->pageTitle = 'Добавление типа — '.Yii::app()->name;

    $this->title = 'Управление типами предложений';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Добавление типа</h5>
        
        <div class="ibox-tools">
            <span class="label label-danger">* отмечены обязательные поля.</span>
        </div>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>


