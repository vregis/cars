<?php

if (empty($model->meta_title))
    $this->pageTitle = $model->title.' — '.Yii::app()->name;
else
    $this->pageTitle = $model->meta_title;

if (empty($model->meta_description))
    Yii::app()->clientScript->registerMetaTag($this->pageTitle, 'description');
else
    Yii::app()->clientScript->registerMetaTag($model->meta_description, 'description');

if (empty($model->meta_keywords))
    Yii::app()->clientScript->registerMetaTag($this->pageTitle, 'keywords');
else
    Yii::app()->clientScript->registerMetaTag($model->meta_keywords, 'keywords');

if (!empty($model->meta_image)) {
    Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.'/resources/articles/'.$model->meta_image, NULL, NULL, array('property'=>'og:image'));            
    Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.'/resources/articles/300_'.$model->meta_image, NULL, NULL, array('property'=>'og:image'));            
}

?>

<?php 

    echo $model->text;