<?php
/* @var $data Offers */

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
            'name'=>'title',
            'type' => 'raw',
            'value' => 'CHtml::link($data->title, array("update", "id"=>$data->id))',
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'category_id',
            'filter'=>CHtml::activeDropDownList($model,'category_id',Categories::getListDataGrouped(),array('empty'=>'Не указана...', 'class' => 'form-control')),
            'value' => '$data->category->name',
            'headerHtmlOptions'=>array('class'=>'col-sm-3'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'owner_id',
            'filter'=>$this->widget(
                'application.components.widgets.beSelect2',
                array(
                    'model'=>$model, 
                    'attribute'=>'owner_id', 
                    'data'=>Profile::getClientsData(), 
                    'url'=>'/user/clients/getData', 
                    'htmlOptions'=>array('class' => 'form-control')
                ),
                true
            ),
            'value' => '$data->owner->profile->name',
            'headerHtmlOptions'=>array('class'=>'col-sm-2'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'date_created',
            'filter'=>$this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_created'), true),
            'value'=>'Yii::app()->locale->dateFormatter->format("d MMMM yyyy, в H:mm", $data->date_created)',
            'htmlOptions'=>array('class'=>'text-center col-xs-2'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-2'),
        ),
        array(
            'class' => 'CDataColumn',
            'header' => '<i class="fa fa-shopping-cart" title="Заказы"></i>',
            'type'=>'raw',
            'filter' => false,
            'value' => 'CHtml::link(count($data->orders), array("/orders/default/admin", "Orders[offer_id]"=>$data->id))',
            'htmlOptions'=>array('class'=>'text-center'),
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
                    'visible'=>'count($data->orders) == 0',
                ),
            ),
            'template'=>'{delete}',
            'htmlOptions'=>array('class'=>'text-center short_cell icon_cell'),
        ),
    ),
));
?>