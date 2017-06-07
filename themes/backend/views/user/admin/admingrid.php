<?php
$this->widget('application.components.widgets.beGridView', array(
    'dataProvider'=>$model->adminSearch(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'CDataColumn',
            'name'=>'user_id',
            'header'=>'#',
            'htmlOptions'=>array('class'=>'text-center'),
            'headerHtmlOptions'=>array('class'=>'text-center short_cell'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'user_id',
            'header'=>'Фамилия, имя',
            'filter'=>$this->widget('application.components.widgets.beSelect2', array(
                'model' => $model,
                'attribute' => 'user_id',
                'data' => Profile::model()->getListData(),
                'url' => '/user/admin/getData'
            ), true),
            'type'=>'raw',
            'value'=>'CHtml::link($data->name, array("update", "id"=>$data->user_id))',
        ),
        array(
            'class'=>'CDataColumn',
            'header'=>'E-mail',
            'name'=>'userEmail',
            'value'=>'$data->user->email',
            'htmlOptions'=>array('class'=>'col-xs-2'),
            'headerHtmlOptions'=>array('class'=>'col-xs-2'),
        ),
        array(
            'class'=>'CDataColumn',
            'header'=>'Роль',
            'filter'=>CHtml::activeDropDownList($model, 'userSuperuser', User::itemAlias("AdminStatus"), array('empty' => 'Не указана')),
            'value'=>'User::itemAlias("AdminStatus", $data->user->superuser)',
            'htmlOptions'=>array('class'=>'col-xs-2'),
            'headerHtmlOptions'=>array('class'=>'col-xs-2'),
        ),
        array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
                'update'=>array(
                    'label'=>'<i class="fa fa-pencil text-warning"></i>',
                    'url'=>'array("/user/admin/update", "id"=>$data->user_id)',
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
                    'url'=>'array("/user/admin/delete", "id"=>$data->user_id)',
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