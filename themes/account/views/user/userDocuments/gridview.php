<?php
/* @var $data UserDocuments */

/**
 * CSS column classes
 * .short_cell
 * .icon_cell
 * .live_editor
 */
 
$this->widget('application.components.widgets.feGridView', array(
    'dataProvider'=>$model->frontendSearch(),
    'emptyText'=>Yii::t('app', 'No results found.'),
    'columns'=>array(
        array(
            'class'=>'CDataColumn',
            'name'=>'title',
            'type' => 'raw',
            'value' => 'CHtml::link($data->title, Yii::app()->request->hostInfo."/resources/documents/".$data->filename, array("target" => "_blank"))',
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'date_uploaded',
            'header'=>'<i class="fa fa-download"></i>',
            'filter'=>$this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_uploaded'), true),
            'value'=>'Yii::app()->locale->dateFormatter->format(Yii::t("app", "dd.MM.yyyy, HH:mm"), $data->date_uploaded)',
            'htmlOptions'=>array('class'=>'text-center col-xs-3'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-3'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'date_approved',
            'header'=>'<i class="fa fa-check"></i>',
            'filter'=>$this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_approved'), true),
            'value'=>'Yii::app()->locale->dateFormatter->format(Yii::t("app", "dd.MM.yyyy, HH:mm"), $data->date_approved)',
            'htmlOptions'=>array('class'=>'text-center col-xs-3'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-3'),
        ),
        array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
                'delete'=>array(
                    'label'=>'<i class="fa fa-times text-danger"></i>',
                    'url'=>'array("/user/userDocuments/delete", "id" => $data->id)',
                    'options'=>array('title'=>Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?')),
                    'imageUrl'=>false,
                    'click'=>'beDelete',
                ),
            ),
            'template'=>'{delete}',
            'htmlOptions'=>array('class' => 'text-center short_cell icon_cell'),
        ),
    ),
));
?>