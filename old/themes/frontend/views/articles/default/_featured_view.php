<?php
/* @var $this ArticlesController */
/* @var $data Articles */
?>

<div class="article-featured-view">
    <?= CHtml::link(CHtml::image(Yii::app()->request->hostInfo.'/resources/articles/500_'.$data->image, $data->title, array('class' => 'img-responsive')), array('/articles/default/view', 'url_name' => $data->url_name)) ?>
    <p><?= CHtml::link($data->title.'<br /><br /><i class="fa fa-bullseye"></i>', array('/articles/default/view', 'url_name' => $data->url_name)) ?></p>
</div>