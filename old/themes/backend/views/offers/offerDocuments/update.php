<?php
/* @var $this OfferDocumentsController */
/* @var $model OfferDocuments */

    $this->breadcrumbs=array(
        'Управление предложениями'=>array('/offers/default/admin'),
        $model->offer->title=>array('/offers/default/update', 'id'=>$model->offer_id),
        'Управление документами'=>array('admin', 'id'=>$model->offer_id),
        'Документ «'.$model->title.'»',
    );

    $this->pageTitle = 'Документ «'.$model->title.'» — '.Yii::app()->name;

    $this->title = 'Предложения';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/default/_tabs', array('model'=>$model->offer)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <?php 
                    if (!$model->is_approved) {
                        echo '<form action="" method="POST">';
                        echo '<button class="btn pull-right btn-warning" type="submit" name="approveDoc"><i class="fa fa-check"></i>&nbsp;&nbsp;Подтвердить документ</button>';
                        echo '</form>';
                    }
                ?>
                <h3>Документ «<?php echo $model->title; ?>»</h3>
                <br />
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
                <?php 
                    if ($model->is_approved) {
                        echo '<br /><br />';
                        echo '<h4 class="text-primary">Документ подтвержден!</h4>';
                        echo '<p>';
                        echo 'Подтвердил: '.$model->approvedBy->profile->name.'<br />';
                        echo 'Дата подтверждения: '.Yii::app()->locale->dateFormatter->format("d MMMM yyyy, в H:mm", $model->date_approved);
                        echo '</p>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>