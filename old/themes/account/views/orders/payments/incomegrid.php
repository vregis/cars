<?php
/* @var $data Payments */

/**
 * CSS column classes
 * .short_cell
 * .icon_cell
 * .live_editor
 */
 
$this->widget('application.components.widgets.feGridView', array(
    'dataProvider'=>$model->mySearch(array(Payments::TYPE_REFILL, Payments::TYPE_RESTORE)),
    'emptyText'=>Yii::t('app', 'No results found.'),
    'columns'=>array(
        array(
            'class'=>'CDataColumn',
            'name'=>'id',
            'type'=>'raw',
            'header'=>Yii::t('app', 'Payment number'),
            'value'=>'CHtml::link(Yii::t("app", "Payment #").$data->id, array("view", "id"=>$data->id))',
            'headerHtmlOptions'=>array('class'=>'col-sm-3'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'order_id',
            'type'=>'raw',
            'header'=>Yii::t('app', 'Order number'),
            'value'=>'((!empty($data->order_id))?(CHtml::link(Yii::t("app", "Order #").$data->order_id, array("/orders/".(($data->client_id == Yii::app()->user->id)?("offered"):("default"))."/view", "id"=>$data->order_id))):("&mdash;"))',
            'headerHtmlOptions'=>array('class'=>'col-sm-2'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'type',
            'value'=>'$data->types[$data->type]',
            'header'=>Yii::t('app', 'Type'),
            'headerHtmlOptions'=>array('class'=>'col-sm-2'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'amount',
            'header'=>Yii::t('app', 'Total cost').', $',
            'headerHtmlOptions'=>array('class'=>'col-sm-2'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'date_approved',
            'filter'=>$this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_approved'), true),
            'value'=>'Yii::app()->locale->dateFormatter->format(Yii::t("app", "d MMMM yyyy, в H:mm"), $data->date_approved)',
            'htmlOptions'=>array('class'=>'text-center col-xs-2'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-3'),
        ),
    ),
));
?>