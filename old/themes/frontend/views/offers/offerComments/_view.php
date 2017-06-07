<?php
/* @var $model OfferComments */
    $model = $data['model'];
?>


    <div class="client-review <?= ((!empty($blinking))?('animated flash'):('')) ?>">
        <div class="client-review-header">
            <div class="client-review-author">
                <?= $model->author->profile->photoPreview ?>
                <p>
                    <?= CHtml::link($model->author->profile->name, $model->author->profileUrl) ?> 
                    <?php if (!empty($model->author->profile->province)) echo CHtml::image(Yii::app()->theme->baseUrl.'/img/flags/'.mb_strtolower($model->author->profile->province->country->code, 'UTF-8').'.png'); ?><br />
                    <?= Yii::app()->locale->dateFormatter->format(Yii::t('app', 'd MMM yyyy, HH:mm'), $model->date_created); ?>
                </p>
            </div>
        </div>

        <div class="client-review-content client-comment-<?= $model->id ?>">
            <?= $this->formatText($model->text) ?>

            <ul class="comments-operations">
                <li><a href="#form-<?= $model->id ?>" class="comment-reply dashed" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="form-<?= $model->id ?>"><i class="fa fa-reply fa-fw"></i> <?= Yii::t('app', 'Reply') ?></a></li>
                <li><?= CHtml::link('<i class="fa fa-envelope-o fa-fw"></i> '.Yii::t('app', 'Send Private Message'), array('/user/privateMessages/dialog', 'id'=>$model->author_id), array('class' => 'send-message dashed')) ?></li>
            </ul>

            <div class="row collapse" id="form-<?= $model->id ?>">
                <div class="col-xs-12 col-md-10">
                    <br />
                    <form action="" method="POST" id="comment-form-<?= $model->id ?>">
                        <div class="form-group">
                            <label for="abc" class="control-label">Your comment:</label>
                            <textarea name="comment_text" class="form-control" id="textarea-<?= $model->id ?>" rows="3"></textarea>
                            <?= CHtml::hiddenField('parent_id', $model->id, array('id' => 'parent-id-'.$model->id)); ?>
                        </div>
                        <div class="form-group">
                            <a href="#" class="btn btn-comment btn-success" data-target="<?= $model->id ?>" data-offer="<?= $model->offer_id ?>"><?= Yii::t('app', 'Submit') ?></a>
                        </div>
                    </form>
                </div>
            </div>

            <?php 
            if (!empty($data['children']))
                foreach ($data['children'] as $child) {
                    $this->renderPartial('/offerComments/_view', array('data' => $child));
                }
            ?>
        </div> 
    </div>  