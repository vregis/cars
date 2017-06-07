<?php 
    $annotation = strip_tags($data->description);
    $annotation = mb_substr($annotation, 0, 512, 'UTF-8');
    
    $page_url = Yii::app()->createAbsoluteUrl($data->route);
?>

<div class="hr-line-dashed"></div>
<div class="search-result">
    <h3><?php echo CHtml::link('МЕТА тег для страницы «'.$data->name.'»', array('/metaTags/default/update', 'id'=>$data->id)); ?></h3>
    <?php echo CHtml::link($page_url, $page_url, array('class' => 'search-link')); ?>
    <p>
    <?php 
        echo $annotation; 
        
        if (mb_strlen($annotation, 'UTF-8') > 512)
            echo '...';
    ?>
    </p>
</div>