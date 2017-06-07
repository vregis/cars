<?php
/* @var $this ArticlesController */
/* @var $model Articles */

    $this->breadcrumbs=array(
        'Управление статьями',
    );

    $this->pageTitle = 'Управление статьями — '.Yii::app()->name;

    $this->title = 'Статьи';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление статьями</h5>
        
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
            echo '<p class="text-right">'.CHtml::link('+ Добавить статью', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>