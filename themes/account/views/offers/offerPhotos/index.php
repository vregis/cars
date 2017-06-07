<?php
/* @var $this PhotosController */
/* @var $model Photos */

    $this->pageTitle = Yii::t('app', 'Offer Photos').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'Offer #').$model->offer_id => array('/offers/default/edit', 'id' => $model->offer_id),
        Yii::t('app', 'Offer Photos')
    );

    $this->renderPartial('/default/_tabs', array('model' => $model->offer));    
?>

    <div class="account-content">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <h3><?= Yii::t('app', 'Offer Photos') ?></h3>
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$model->search(),
                    'template'=>'{items}',
                    'itemView'=>'_view',
                    'itemsCssClass'=>'row sortable-view',
                    'emptyText'=>'<p class="text-muted">'.Yii::t('app', 'No images uploaded.').'</p>',
                    'emptyCssClass'=>'col-xs-12',
                    'emptyTagName'=>'div',
                    'htmlOptions'=>array('data-model' => '/offers/offerPhotos'),
                ));
                ?>
                <div id="serialize_output"></div>                
            </div>
            <div class="col-xs-12 col-sm-4">
                <h3><?= Yii::t('app', 'Add Photos') ?></h3>
                <br />

                <?php echo $this->renderPartial('_form', array('model'=>$form_model)); ?>                
            </div>
        </div>        
    </div>