<?php
/* @var $this ArticlesController */
/* @var $data Articles */
?>

<div class="article-liteview">
    <?php echo CHtml::link(CHtml::image(Yii::app()->request->hostInfo.'/resources/articles/500_'.$data->image, $data->title, array('class' => 'img-responsive')), array('/articles/default/view', 'url_name' => $data->url_name)); ?>
    <h4><?php echo CHtml::link($data->title, array('/articles/default/view', 'url_name' => $data->url_name)); ?></h4>
</div>