<?php
    $this->pageTitle = Yii::t('app', 'Pending Reviews').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'Pending Reviews')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Pending Reviews') ?></h3>
        
        <?php
        $this->widget('application.components.widgets.feGridView', array(
            'dataProvider'=>$model->reviewsSearch(false),
            'itemsCssClass'=>'table archived-offers',
            'emptyText'=>Yii::t('app', 'No results found.'),
            'columns'=>array(
                array(
                    'class'=>'feOrderReviewTitleColumn',
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
        ?>
    </div>