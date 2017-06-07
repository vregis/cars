<?php
/* @var $this ArticlesController */
/* @var $data Articles */
?>

<div class="article-view">
    <?php echo CHtml::link(CHtml::image(Yii::app()->request->hostInfo.'/resources/articles/'.$data->image, $data->title, array('class' => 'img-responsive')), array('/articles/default/view', 'url_name' => $data->url_name)); ?>
    <div class="article-preview">
        <h4><?php echo CHtml::link($data->title, array('/articles/default/view', 'url_name' => $data->url_name)); ?></h4>
        <p class="text-muted text-right"><small><?= Yii::t('app', 'Published on').' '.Yii::app()->locale->dateFormatter->format(Yii::t('app', 'd MMMM yyyy'), $data->date_created) ?></small></p>
        <?php echo $data->annotation; ?>
        <p class="text-right"><?php echo CHtml::link(Yii::t('app', 'Read more...'), array('/articles/default/view', 'url_name' => $data->url_name), array('class' => 'btn btn-default')); ?></p>
    </div>
</div>