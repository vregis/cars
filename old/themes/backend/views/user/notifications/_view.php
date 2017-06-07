<?php
    switch ($data->type) {
        case 0: $image = 'notification_0.png'; break;
        case 1: $image = 'notification_1.png'; break;
        case 2: $image = 'notification_2.png'; break;
        default: $image = 'notification_0.png'; break;
    }
?>

<li>
    <div class="dropdown-messages-box notification-message active" data-id="<?php echo $data->id; ?>">
        <?php echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/img/'.$image, $data->types[$data->type], array('class' => 'img-circle')), array('/notifications/view', 'id'=>$data->id), array('class'=>'pull-left')); ?>
        <div class="media-body">
            <small class="pull-right text-info notif-time-left"><?php echo $data->timeLeft; ?></small>
            <?php echo $data->text; ?><br>
            <small class="text-muted"><?php echo Yii::app()->locale->dateFormatter->format('d MMMM yyyy г. в H:mm', $data->date); ?></small>
        </div>
    </div>
</li>
<li class="divider"></li>