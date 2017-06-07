<?php
/* @var $data UserDocuments */

/**
 * CSS column classes
 * .short_cell
 * .icon_cell
 * .live_editor
 */
 
$this->widget('application.components.widgets.feGridView', array(
    'dataProvider'=>$model->clientSearch(array(Orders::STATUS_CANCELED, Orders::STATUS_SUCCESSFUL)),
    'itemsCssClass'=>'table archived-offers',
    'emptyText'=>Yii::t('app', 'No results found.'),
    'columns'=>array(
        array(
            'class'=>'feOrderTitleColumn',
            'header'=>'',
            'type' => 'raw',
            'value' => '$data',
            'htmlOptions' => array('class' => 'archived-offer-name')
        ),
        array(
            'class'=>'feOrderPriceColumn',
            'name'=>'status',
            'type' => 'raw',
            'value'=>'$data',
            'htmlOptions'=>array('class'=>'archived-offer-price col-xs-2'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-2'),
        ),
        array(
            'class'=>'CDataColumn',
            'type' => 'raw',
            'header'=>Yii::t('app', 'Period'),
            'value'=>'Yii::app()->locale->dateFormatter->format(Yii::t("app", "d MMM yyyy, в H:mm"), $data->date_since)."<br />".Yii::app()->locale->dateFormatter->format(Yii::t("app", "d MMM yyyy, в H:mm"), $data->date_for)',
            'htmlOptions'=>array('class'=>'text-center col-xs-3'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-3'),
        ),
    ),
));