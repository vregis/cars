<?php
    /* @var $this OfferFaqController */
    /* @var $model OfferFaq */

    $this->breadcrumbs=array(
        'Управление предложениями'=>array('/offers/default/admin'),
        $model->offer->title=>array('/offers/default/update', 'id'=>$model->offer_id),
        'Управление вопросами',
    );

    $this->pageTitle = 'Управление вопросами — '.Yii::app()->name;

    $this->title = 'Предложения';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/default/_tabs', array('model'=>$model->offer)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Управление вопросами</h3>
                <br />
                <?php
                    echo '<p class="text-right">'.CHtml::link('+ Добавить вопрос', array('create', 'id'=>$model->offer_id), array('class'=>'btn btn-primary text-right')).'</p>';
            
                    $this->renderPartial('admingrid', array('model'=>$model));
                ?>
            </div>
        </div>
    </div>
</div>