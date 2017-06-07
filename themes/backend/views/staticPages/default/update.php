<?php
/* @var $this StaticPagesController */
/* @var $model StaticPages */

    $this->breadcrumbs=array(
        'Управление инфо-страницами'=>array('admin'),
        'Страница «'.$model->menu_name.'»'
    );

    $this->pageTitle = 'Страница «'.$model->menu_name.'» — '.Yii::app()->name;

    $this->title = 'Инфо-страницы';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>