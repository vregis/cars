<?php 
    $page_url = Yii::app()->createAbsoluteUrl('/parameters/update', array('id'=>$data->id));
?>

<div class="hr-line-dashed"></div>
<div class="search-result">
    <h3><?php echo CHtml::link('Значение параметра: '.$data->value, array('/parameterValues/update', 'id'=>$data->id)); ?></h3>
    <?php echo CHtml::link('Параметр «'.$data->parameter->name.'»', $page_url, array('class' => 'search-link')); ?>
</div>