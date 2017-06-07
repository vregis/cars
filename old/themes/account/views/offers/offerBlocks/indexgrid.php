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
            'name'=>'date_since',
            'filter'=>$this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_since'), true),
            'value'=>'Yii::app()->locale->dateFormatter->format(Yii::t("app", "d.MM.yyyy, в H:mm"), $data->date_since)',
            'htmlOptions'=>array('class'=>'text-center'),
            'headerHtmlOptions'=>array('class'=>'text-center'),
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'date_for',
            'filter'=>$this->widget('application.components.widgets.beDatepicker',array('model'=>$model, 'attribute'=>'date_for'), true),
            'value'=>'Yii::app()->locale->dateFormatter->format(Yii::t("app", "d.MM.yyyy, в H:mm"), $data->date_for)',
            'htmlOptions'=>array('class'=>'text-center'),
            'headerHtmlOptions'=>array('class'=>'text-center'),
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