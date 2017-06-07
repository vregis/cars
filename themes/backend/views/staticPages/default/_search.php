<?php 
    $page_url = Yii::app()->createAbsoluteUrl('/staticPages/default/view', array('url_name' => $data->url_name));
?>

<div class="hr-line-dashed"></div>
<div class="search-result">
    <h3><?php echo CHtml::link('Инфо-страница «'.$data->title.'»', array('/staticPages/default/update', 'id'=>$data->id)); ?></h3>
    <?php echo CHtml::link($page_url, $page_url, array('class' => 'search-link')); ?>
    <p>
    <?php 
        echo strip_tags(mb_substr($data->text, 0, 512, 'UTF-8')); 
        
        if (mb_strlen($data->text, 'UTF-8') > 512)
            echo '...';
    ?>
    </p>
</div>