<?php
/* @var $this MetaTagsController */
/* @var $model MetaTags */

    $this->breadcrumbs=array(
        'Управление мета тегами',
    );

    $this->pageTitle = 'Управление мета тегами — '.Yii::app()->name;

    $this->title = 'МЕТА теги';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление мета тегами</h5>
        
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
            echo '<p class="text-right">'.CHtml::link('+ Добавить тег', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>