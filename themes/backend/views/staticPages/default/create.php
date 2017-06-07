<?php
/* @var $this StaticPagesController */
/* @var $model StaticPages */

    $this->breadcrumbs=array(
        'Управление инфо-страницами'=>array('admin'),
        'Добавление страницы'
    );

    $this->pageTitle = 'Добавление страницы — '.Yii::app()->name;

    $this->title = 'Инфо-страницы';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>