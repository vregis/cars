<?php
/* @var $this MetaTagsController */
/* @var $model MetaTags */

    $this->breadcrumbs=array(
        'Управление мета тегами'=>array('admin'),
        'Редактирование мета тега для "'.$model->route.'"',
    );

    $this->pageTitle = 'Редактирование мета тега для "'.$model->route.'" — '.Yii::app()->name;

    $this->title = 'МЕТА теги';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование мета тега для "<?php echo $model->route; ?>"</h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>