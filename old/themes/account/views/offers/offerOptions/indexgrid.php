<?php
/* @var $data OfferOptions */

/**
 * CSS column classes
 * .short_cell
 * .icon_cell
 * .live_editor
 */
 
$this->widget('application.components.widgets.feGridView', array(
    'dataProvider'=>$model->search(),
    'columns'=>array(
        array(
            'class'=>'CDataColumn',
            'name'=>'title',
            'type' => 'raw',
            'value' => 'CHtml::link($data->title, array("edit", "id"=>$data->id))',
        ),
        array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
                'update'=>array(
                    'label'=>'<i class="fa fa-pencil text-warning"></i>',
                    'options'=>array('title'=>Yii::t('app', 'Edit')),
                    'imageUrl'=>false,
                    'url'=>'array("edit", "id" => $data->id)',
                ),
            ),
            'template'=>'{update}',
            'htmlOptions'=>array('class'=>'text-center col-xs-1'),
        ),
        array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
                'delete'=>array(
                    'label'=>'<i class="fa fa-times text-danger"></i>',
                    'options'=>array('title'=>Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?')),
                    'imageUrl'=>false,
                    'click'=>'beDelete',
                    'visible'=>'count($data->orderedOptions) == 0',
                ),
            ),
            'template'=>'{delete}',
            'htmlOptions'=>array('class'=>'text-center col-xs-1'),
        ),
    ),
));
?>