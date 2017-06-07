<?php 
    
?>

<div class="hr-line-dashed"></div>
<div class="search-result">
    <h3><?php echo CHtml::link('Уведомление #'.$data->id.' от '.Yii::app()->locale->dateFormatter->format('d MMMM yyyy, H:mm', $data->date), array('/notifications/admin', 'Notifications[id]'=>$data->id)); ?></h3>
    <p>
    <?php echo strip_tags($data->text); ?>
    </p>
</div>