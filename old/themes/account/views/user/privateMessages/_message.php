<?php
    $author = $data->sender;
    
    $class = '';
    if ($data->is_seen == 0) 
        if ($data->recepient_id == Yii::app()->user->id) 
            $class = 'unseen';
        else
            $class = 'unseen-passive';
?>
<div class="message-container <?= $class ?>" data-id="<?= $data->id ?>">
    <div class="row">
        <div class="col-xs-2 col-sm-1 message-profile">
            <?= CHtml::link(CHtml::image($author->profile->squarePhoto, $author->profile->name, array('class' => 'img-responsive img-circle')), $author->profileUrl) ?>
        </div>
        <div class="col-xs-10 col-sm-11">
            <div class="message-text">
                <h5>
                    <?= CHtml::link($author->profile->name, $author->profileUrl) ?>
                    <?= CHtml::link('<i class="fa fa-eye-slash"></i>', array('/user/privateMessages/remove', 'id' => $data->id), array('class' => 'remove-link', 'confirm' => Yii::t('app', 'Are you sure you want to hide this message?'))) ?>
                </h5>
                <p class="date"><?= Yii::app()->locale->dateFormatter->format('d MMMM yyyy, H:mm', $data->date_created) ?></p>
                <p><?= nl2br(CHtml::encode($data->text)) ?></p>
            </div>    
        </div>   
    </div>
</div>