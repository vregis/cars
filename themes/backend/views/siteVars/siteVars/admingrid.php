<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->search(),
    'cssFile'=>false,
    'template'=>'{items}',
    'selectableRows'=>0,
    'afterAjaxUpdate'=>'gridUpdate',
    'itemsCssClass'=>'table table-striped table-bordered table-hover dataTables-example',
    'columns'=>array(
        array(
            'class'=>'CDataColumn',
            'name'=>'id',
            'header'=>'',
            'htmlOptions'=>array('class'=>'text-center'),
            'headerHtmlOptions'=>array('class'=>'text-center short_cell'),
        ),
        array(
            'class' => 'CDataColumn',
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name, array("update", "id"=>$data->id))',
            'htmlOptions'=>array('class'=>''),
            'headerHtmlOptions'=>array('class'=>''),
        ),
        array(
            'class' => 'CDataColumn',
            'name' => 'description',
        ),
        array(
            'class' => 'CDataColumn',
            'name' => 'field_type',
            'filter' => CHtml::activeDropDownList($model,'field_type',$model->types,array('empty'=>'Не указан')),
            'value' => '$data->types[$data->field_type]',
            'htmlOptions'=>array('class'=>'text-center'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-2'),
        ),
        array(
            'class' => 'phaCheckColumn',
            'header' => '<i class="fa fa-paragraph" title="Включить визуальный редактор"></i>',
            'name' => 'wysiwyg_on',
            'filter' => false,
            'actionUrl' => array('setWysiwyg'),
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