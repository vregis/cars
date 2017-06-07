<?php
    /* @var $this OfferOptionsController */
    /* @var $model OfferOptions */

    $this->breadcrumbs=array(
        'Управление предложениями'=>array('/offers/default/admin'),
        $model->offer->title=>array('/offers/default/update', 'id'=>$model->offer_id),
        'Управление опциями',
    );

    $this->pageTitle = 'Управление опциями — '.Yii::app()->name;

    $this->title = 'Предложения';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/default/_tabs', array('model'=>$model->offer)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Управление опциями</h3>
                <br />
                <?php
                    echo '<p class="text-right">'.CHtml::link('+ Добавить опцию', array('create', 'id'=>$model->offer_id), array('class'=>'btn btn-primary text-right')).'</p>';
            
                    $this->renderPartial('admingrid', array('model'=>$model));
                ?>
            </div>
        </div>
    </div>
</div>