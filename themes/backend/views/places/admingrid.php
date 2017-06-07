<?php
/* @var $data Places */

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
            'htmlOptions'=>array('class'=>''),
            'headerHtmlOptions'=>array('class'=>'col-sm-5'),
        ),
        array(
            'class'=>'CDataColumn',
            'header'=>'Провинция/регион',
            'type'=>'raw',
            'filter'=>$this->widget('application.components.widgets.beSelect2',array('model'=>$model, 'attribute'=>'province_id', 'data' => ListProvinces::model()->listData, 'url' => '//listProvinces/getData'), true),
            'value'=>'(!empty($data->parent))?(CHtml::link($data->parent->name, array("update", "id"=>$data->parent_id))):("<span class=\"text-muted\">Корневая категория</span>")',
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