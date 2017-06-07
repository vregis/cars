<?php
/* @var $this PopupsController */
/* @var $data Popups */
?>

<div class="modal fade popup-default" data-delay="<?= $data->delay ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <?php
                if (!empty($data->html))
                    echo $data->html;
                elseif (!empty($data->link))
                    echo CHtml::link(CHtml::image(Yii::app()->request->hostInfo.'/resources/popups/'.$data->image, $data->title, array('class' => 'img-responsive')), $data->link);
                else
                    echo CHtml::image(Yii::app()->request->hostInfo.'/resources/popups/'.$data->image, $data->title, array('class' => 'img-responsive'));
                ?>
            </div>
        </div>
    </div>
</div>