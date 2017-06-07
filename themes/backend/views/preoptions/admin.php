<?php
    /* @var $this CategoriesController */
    /* @var $model Categories */

    $this->breadcrumbs=array(
        'Управление категориями'=>array('/categories/admin'),
        'Редактирование категории «'.$model->category->name.'»'=>array('/categories/update', 'id' => $model->category_id),
        'Управление опциями'
    );

    $this->pageTitle = 'Управление опциями — '.Yii::app()->name;

    $this->title = 'Категории';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление опциями</h5>
        
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
            echo '<p class="text-right">'.CHtml::link('+ Добавить опцию', array('create', 'id' => $model->category_id), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>