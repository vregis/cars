<?php
/* @var $data OfferDocuments */

/**
 * CSS column classes
 * .short_cell
 * .icon_cell
 * .live_editor
 */
 
$this->widget('application.components.widgets.feGridView', array(
    'dataProvider'=>$model->search(),
    'columns'=>array(
        array(
            'class'=>'CDataColumn',
            'name'=>'title',
            'type' => 'raw',
            'value' => 'CHtml::link($data->title, array("edit", "id"=>$data->id))',
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'date_uploaded',
            'filter'=>$this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_uploaded'), true),
            'value'=>'Yii::app()->locale->dateFormatter->format(Yii::t("app", "d.MM.yyyy, в H:mm"), $data->date_uploaded)',
            'htmlOptions'=>array('class'=>'text-center col-xs-3'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-3'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'date_approved',
            'filter'=>$this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_approved'), true),
            'value'=>'Yii::app()->locale->dateFormatter->format(Yii::t("app", "d.MM.yyyy, в H:mm"), $data->date_approved)',
            'htmlOptions'=>array('class'=>'text-center col-xs-3'),
            'headerHtmlOptions'=>array('class'=>'text-center col-xs-3'),
        ),
        array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
                'update'=>array(
                    'label'=>'<i class="fa fa-pencil text-warning"></i>',
                    'options'=>array('title'=>Yii::t('app', 'Edit')),
                    'imageUrl'=>false,
                    'url'=>'array("edit", "id" => $data->id)',
                ),
            ),
            'template'=>'{update}',
            'htmlOptions'=>array('class'=>'text-center col-xs-1'),
        ),
        array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
                'delete'=>array(
                    'label'=>'<i class="fa fa-times text-danger"></i>',
                    'options'=>array('title'=>Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?')),
                    'imageUrl'=>false,
                    'click'=>'beDelete',
                ),
            ),
            'template'=>'{delete}',
            'htmlOptions'=>array('class'=>'text-center col-xs-1'),
        ),
    ),
));
?>