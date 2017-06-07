
<?php
/* @var $data Parameters */

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
            'name'=>'id',
            'header'=>'#',
            'htmlOptions'=>array('class'=>'text-center'),
            'headerHtmlOptions'=>array('class'=>'text-center short_cell'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name, array("update", "id"=>$data->id))',
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'type',
            'filter'=>CHtml::activeDropDownList($model,'type',$model->types,array('empty' => 'Не указан')),
            'type' => 'raw',
            'value' => '$data->types[$data->type]',
            'htmlOptions'=>array('class'=>'col-xs-3'),
            'headerHtmlOptions'=>array('class'=>'col-xs-3'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'group_id',
            'filter'=>CHtml::activeDropDownList($model,'group_id', ParameterGroups::model()->listData, array('empty' => 'Не указана')),
            'type' => 'raw',
            'value' => '$data->group->name',
            'htmlOptions'=>array('class'=>'col-xs-2'),
            'headerHtmlOptions'=>array('class'=>'col-xs-2'),
        ),
        array(
            'class'=>'CDataColumn',
            'header'=>'Значения',
            'type' => 'raw',
            'value' => '(($data->type == 0 || $data->type == 4)?(CHtml::link(count($data->values), array("/parameters/parameterValues/admin", "id"=>$data->id))):("&mdash;"))',
            'htmlOptions'=>array('class'=>'text-center col-xs-1'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-1'),
        ),
        array(
            'class' => 'phaEditColumn',
            'header' => '<i class="fa fa-sort-alpha-asc" title="Сортировка"></i>',
            'name' => 'order',
            'filter' => false,
            'actionUrl' => array('setOrder'),
            'htmlOptions'=>array('class'=>'text-center live_editor'),
            'headerHtmlOptions'=>array('class'=>'text-center short_cell'),
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