<?php
/* @var $data UserDocuments */

/**
 * CSS column classes
 * .short_cell
 * .icon_cell
 * .live_editor
 */
 
$this->widget('application.components.widgets.feGridView', array(
    'dataProvider'=>$model->archivedSearch(),
    'itemsCssClass'=>'table archived-offers',
    'emptyText'=>Yii::t('app', 'No results found.'),
    'columns'=>array(
        array(
            'class'=>'feOrderTitleColumn',
            'header'=>'',
            'type' => 'raw',
            'value' => '$data->offer',
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
            'name'=>'date_since',
            'value'=>'Yii::app()->locale->dateFormatter->format(Yii::t("app", "d MMM yyyy, в H:mm"), $data->date_since)',
            'htmlOptions'=>array('class'=>'text-center col-xs-2'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-2'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'date_for',
            'value'=>'Yii::app()->locale->dateFormatter->format(Yii::t("app", "d MMM yyyy, в H:mm"), $data->date_for)',
            'htmlOptions'=>array('class'=>'text-center col-xs-2'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-2'),
        ),
    ),
));