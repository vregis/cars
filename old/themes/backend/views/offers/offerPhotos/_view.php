<div class="col-xs-3 draggable_block" data-id="<?php echo $data->id; ?>">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Изображение #<?php echo $data->id; ?></h5>

            <div class="ibox-tools">
                <?php echo CHtml::link('<i class="fa fa-times text-danger"></i>', array('/offers/offerPhotos/delete', 'id' => $data->id), array('class'=>'delete-link','title'=>'Удалить')); ?>
            </div>
        </div>
        <div class="ibox-content">
            <?php                 
                echo CHtml::link(CHtml::image(Yii::app()->request->hostInfo.'/resources/offers/600_'.$data->filename, 'Изображение #'.$data->id, array('width'=>'100%')), Yii::app()->request->hostInfo.'/resources/offers/'.$data->filename, array('target'=>'_blank'));
            ?>
        </div>
    </div>
</div>
<?php if ($index % 4 == 3) echo '<div class="clearfix"></div>';