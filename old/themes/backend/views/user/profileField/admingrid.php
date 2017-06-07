<?php
$this->widget('application.components.widgets.beGridView', array(
    'dataProvider'=>$dataProvider,
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
            'type'=>'raw',
            'name'=>'title',
            'value'=>'CHtml::link(UserModule::t($data->title), array("update", "id" => $data->id))',
        ),
        'varname',
        array(
            'class'=>'CDataColumn',
            'name'=>'position',
            'htmlOptions'=>array('class'=>'text-center'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-2'),
        ),
        array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
                'update'=>array(
                    'label'=>'<i class="fa fa-pencil text-warning"></i>',
                    'url'=>'array("update", "id"=>$data->id)',
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
                    'url'=>'array("delete", "id"=>$data->id)',
                    'options'=>array('title'=>'Удалить'),
                    'click'=>'beDelete',
                    'imageUrl'=>false,
                ),
            ),
            'template'=>'{delete}',
            'htmlOptions'=>array('class'=>'text-center short_cell icon_cell'),
        ),
    ),
));
?>