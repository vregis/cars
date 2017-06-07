<?php 
    $annotation = strip_tags($data->value);
    $annotation = mb_substr($annotation, 0, 512, 'UTF-8');
?>

<div class="hr-line-dashed"></div>
<div class="search-result">
    <h3><?php echo CHtml::link('Переменная «'.$data->name.'»', array('/siteVars/default/update', 'id'=>$data->id)); ?></h3>
    <p>
    <?php 
        echo $annotation; 
        
        if (mb_strlen($annotation, 'UTF-8') > 512)
            echo '...';
    ?>
    </p>
</div>