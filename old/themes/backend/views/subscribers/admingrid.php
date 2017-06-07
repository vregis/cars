<?php
/* @var $data Subscribers */

/**
 * CSS column classes
 * .short_cell
 * .icon_cell
 * .live_editor
 */
 
$this->widget('application.components.widgets.beGridView', array(
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'CDataColumn',
            'name'=>'email',
            'type' => 'raw',
            'value' => 'CHtml::link($data->email, array("update", "id"=>$data->id))',
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'name',
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'date_created',
            'filter'=>$this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_created'),true),
            'value'=>'Yii::app()->locale->dateFormatter->format("d MMMM yyyy, в H:mm:ss", $data->date_created)',
            'htmlOptions'=>array('class'=>'text-center col-xs-2'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-2'),
        ),
        array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
                'update'=>array(
                    'label'=>'<i class="fa fa-pencil text-warning"></i>',
                    'options'=>array('title'=>'Редактировать'),
                    'imageUrl'=>false,
                ),
            ),
            'template'=>'{update}',
            'htmlOptions'=>array('class'=>'text-center short_cell icon_cell'),
        ),
        array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
                'delete'=>array(
                    'label'=>'<i class="fa fa-times text-danger"></i>',
                    'options'=>array('title'=>'Удалить'),
                    'imageUrl'=>false,
                    'click'=>'beDelete',
                ),
            ),
            'template'=>'{delete}',
            'htmlOptions'=>array('class'=>'text-center short_cell icon_cell'),
        ),
    ),
));
?>