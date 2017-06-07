<?php 
    $page_url = Yii::app()->createAbsoluteUrl('/articles/default/view', array('url_name' => $data->url_name));
?>

<div class="hr-line-dashed"></div>
<div class="search-result">
    <h3><?php echo CHtml::link('Статья «'.$data->title.'»', array('/articles/default/update', 'id'=>$data->id)); ?></h3>
    <?php echo CHtml::link($page_url, $page_url, array('class' => 'search-link')); ?>
    <p>
    <?php echo strip_tags($data->annotation); ?>
    </p>
</div>