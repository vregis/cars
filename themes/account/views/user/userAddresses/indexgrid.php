<?php
/* @var $data OfferAddresses */

/**
 * CSS column classes
 * .short_cell
 * .icon_cell
 * .live_editor
 */
 
$this->widget('application.components.widgets.feGridView', array(
    'dataProvider'=>$model->search(),
    'emptyText'=>Yii::t('app', 'No results found.'),
    'columns'=>array(
        array(
            'class'=>'CDataColumn',
            'name'=>'address',
            'type' => 'raw',
            'value' => 'CHtml::link($data->address, array("edit", "id"=>$data->id))',
        ),
        array(
            'class'=>'CDataColumn',
            'name'=>'city',
            'headerHtmlOptions' => array('class' => 'col-sm-3')
        ),
        array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
                'delete'=>array(
                    'label'=>'<i class="fa fa-times text-danger"></i>',
                    'options'=>array('title'=>Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?')),
                    'imageUrl'=>false,
                    'click'=>'beDelete',
                    'visible'=>'(count($data->offersAddresses) == 0)',
                ),
            ),
            'template'=>'{delete}',
            'htmlOptions'=>array('class'=>'text-center short_cell icon_cell'),
        ),
    ),
));
?>