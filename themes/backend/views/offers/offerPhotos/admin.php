<?php
/* @var $this PhotosController */
/* @var $model Photos */

    $this->breadcrumbs=array(
        'Управление предложениями'=>array('/offers/default/admin'),
        $model->offer->title=>array('/offers/default/update', 'id'=>$model->offer_id),
        'Управление изображениями',
    );

    $this->pageTitle = 'Управление изображениями — '.Yii::app()->name;

    $this->pageTitle = 'Предложения';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/default/_tabs', array('model'=>$model->offer)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Управление изображениями</h3>
                <br />
                <?php echo $this->renderPartial('_form', array('model'=>$form_model)); ?>
            </div>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$model->search(),
        'template'=>'{items}',
        'itemView'=>'_view',
        'itemsCssClass'=>'row sortable-view',
        'emptyText'=>'<p class="text-center">Нет загруженных изображений.</p>',
        'htmlOptions'=>array('data-model' => '/offers/offerPhotos'),
    ));
    ?>
    <div id="serialize_output"></div>
</div>