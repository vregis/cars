<?php
/* @var $this OfferReviewsController */
/* @var $data OfferReviews */
?>

    <div class="client-review">                        
        <div class="row">     
            <div class="col-xs-12">
                <div class="client-review-content">
                    <h5><?= Yii::t('app', 'Question') ?>:</h5>
                    <?= $this->formatText($data->question) ?>
                    <h5><?= Yii::t('app', 'Answer') ?>:</h5>
                    <?= $this->formatText($data->answer) ?>
                </div> 
            </div>
        </div>
    </div>   

    <hr />