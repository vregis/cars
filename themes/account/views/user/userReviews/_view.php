<?php
/* @var $this UserReviewsController */
/* @var $data UserReviews */
    $rating = ($data->parameter_1 + $data->parameter_2 + $data->parameter_3) / 3;
?>

    <div class="client-review" data-rating="<?= $rating ?>">                        
        <div class="row client-review-header">
            <div class="col-xs-7 col-sm-8">
                <div class="client-review-author">   
                    <?= $data->user->profile->photoPreview ?>
                    <p>
                        <?= CHtml::link($data->user->profile->name, $data->user->profileUrl) ?> 
                        <?php if (!empty($data->user->profile->province)) echo CHtml::image(Yii::app()->theme->baseUrl.'/img/flags/'.mb_strtolower($data->user->profile->province->country->code, 'UTF-8').'.png'); ?><br />
                        <?= Yii::app()->locale->dateFormatter->format(Yii::t('app', 'd MMM yyyy, в H:mm'), $data->date_created); ?>
                    </p>
                </div>
            </div>
            <div class="col-xs-5 col-sm-4 client-review-rating">
                <?php $this->widget('application.components.widgets.feRatingStars', array(
                    'rating'=>$rating,
                    'htmlOptions'=>array('class' => 'star-rating-small'),
                )); ?>
            </div>
        </div>                       
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="client-review-content">
                    <?= $this->formatText($data->text) ?>
                </div>
            </div>
            <div class="col-xs-12 col-md-4 client-review-stats">
                <div class="client-stats">
                    <div class="client-stats-parameter">
                        <div class="parameter-name">
                            <?= Yii::t('app', 'Communications') ?>
                        </div>
                        <?php $this->widget('application.components.widgets.feLineRating', array('rating'=>$data->parameter_1, 'htmlOptions' => array('class' => 'parameter-value'), 'showRating' => false)); ?>
                    </div>
                    <div class="client-stats-parameter">
                        <div class="parameter-name">
                            <?= Yii::t('app', 'Punctuality') ?>
                        </div>
                        <?php $this->widget('application.components.widgets.feLineRating', array('rating'=>$data->parameter_2, 'htmlOptions' => array('class' => 'parameter-value'), 'showRating' => false)); ?>
                    </div>
                    <div class="client-stats-parameter">
                        <div class="parameter-name">
                            <?= Yii::t('app', 'Accuracy') ?>
                        </div>
                        <?php $this->widget('application.components.widgets.feLineRating', array('rating'=>$data->parameter_3, 'htmlOptions' => array('class' => 'parameter-value'), 'showRating' => false)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>