<?php
/* @var $data Orders */

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
            'type'=>'raw',
            'header'=>'Номер заказа',
            'value'=>'CHtml::link("Заказ #".$data->id, array("update", "id"=>$data->id))',
            'headerHtmlOptions'=>array('class'=>'col-sm-2'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'total_cost',
            'headerHtmlOptions'=>array('class'=>'col-sm-2'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'offer_id',
            'filter'=>$this->widget(
                'application.components.widgets.beSelect2',
                array(
                    'model'=>$model, 
                    'attribute'=>'offer_id', 
                    'data'=>Offers::getData(),
                    'url'=>'/offers/default/getData',
                    'htmlOptions'=>array('class' => 'form-control')
                ),
                true
            ),
            'value'=>'$data->offer->title',
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'client_id',
            'filter'=>$this->widget(
                'application.components.widgets.beSelect2',
                array(
                    'model'=>$model, 
                    'attribute'=>'client_id', 
                    'data'=>Profile::getClientsData(), 
                    'url'=>'/user/clients/getData', 
                    'htmlOptions'=>array('class' => 'form-control')
                ),
                true
            ),
            'value' => '$data->client->profile->name',
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
                    'visible'=>'count($data->approvedPayments) == 0',
                ),
            ),
            'template'=>'{delete}',
            'htmlOptions'=>array('class'=>'text-center short_cell icon_cell'),
        ),
    ),
));
?>