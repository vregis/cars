<?php
/* @var $data ListCountries */

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
            'name'=>'code',
            'htmlOptions'=>array('class'=>'col-sm-2 text-center'),
            'headerHtmlOptions'=>array('class'=>'col-sm-2 text-center'),
        ),
        array(
            'class'=>'CDataColumn',
            'header'=>'Провинции/регионы',
            'type'=>'raw',
            'value'=>'CHtml::link(count($data->provinces), array("/listProvinces/admin", "id" => $data->id))',
            'htmlOptions'=>array('class'=>'col-sm-2 text-center'),
            'headerHtmlOptions'=>array('class'=>'col-sm-2 text-center'),
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