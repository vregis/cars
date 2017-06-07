<?php
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
            'name'=>'title',
            'type' => 'raw',
            'value' => 'CHtml::link($data->title, array("update", "id"=>$data->id))',
        ),
        array(
            'class'=>'CDataColumn',
            'header'=>'Родительская страница',
            'type'=>'raw',
            'filter'=>CHtml::activeDropDownList($model, 'parent_id', StaticPages::getListData(), array('empty' => 'Не указана')),
            'value'=>'(!empty($data->parent))?(CHtml::link($data->parent->title, array("update", "id"=>$data->parent_id))):("<span class=\"text-muted\">Корневая страница</span>")',
            'htmlOptions'=>array('class'=>''),
            'headerHtmlOptions'=>array('class'=>''),
        ),
        array(
            'class' => 'CDataColumn',
            'header' => '<i class="fa fa-sitemap" title="Количество дочерних страниц"></i>',
            'filter' => false,
            'value' => 'count($data->children)',
            'htmlOptions'=>array('class'=>'text-center'),
            'headerHtmlOptions'=>array('class'=>'text-center short_cell'),
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
            'class' => 'phaCheckColumn',
            'header' => '<i class="fa fa-eye" title="Отображать на сайте"></i>',
            'name' => 'visible',
            'filter' => false,
            'actionUrl' => array('setVisible'),
            'htmlOptions'=>array('class'=>'text-center'),
            'headerHtmlOptions'=>array('class'=>'text-center short_cell'),
        ),
        array(
            'class' => 'CDataColumn',
            'header' => '&nbsp;',
            'filter' => false,
            'type' => 'raw',
            'value' => 'CHtml::link("<i class=\'fa fa-external-link-square\'></i>", $data->getUrl(), array("title"=>"Перейти на страничку", "class"=>"text-muted"))',
            'htmlOptions'=>array('class'=>'text-center short_cell'),
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
            'htmlOptions'=>array('class'=>'text-center short_cell'),
        ),
        array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
                'delete'=>array(
                    'label'=>'<i class="fa fa-times text-danger"></i>',
                    'options'=>array('title'=>'Удалить'),
                    'imageUrl'=>false,
                    'click'=>'beDelete'
                ),
            ),
            'template'=>'{delete}',
            'htmlOptions'=>array('class'=>'text-center short_cell'),
        ),
    ),
));
?>