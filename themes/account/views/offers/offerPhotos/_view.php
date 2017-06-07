<div class="col-xs-3 acc-photo-block draggable_block" data-id="<?php echo $data->id; ?>">
    <?php                 
        echo CHtml::link(CHtml::image(Yii::app()->request->hostInfo.'/resources/offers/400_'.$data->filename, Yii::t('app', 'Image #').$data->id, array('width'=>'100%')), Yii::app()->request->hostInfo.'/resources/offers/'.$data->filename, array('target'=>'_blank', 'class' => 'handle-draggable'));
        echo CHtml::link('<span>Remove <i class="fa fa-times"></i></span>', array('/offers/offerPhotos/delete', 'id' => $data->id), array('class'=>'photo-delete-icon', 'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'submit' => array('delete', 'id' => $data->id), 'params' => array('id' => $data->id))); 
    ?>
</div>
<?php if ($index % 4 == 3) echo '<div class="clearfix"></div>';