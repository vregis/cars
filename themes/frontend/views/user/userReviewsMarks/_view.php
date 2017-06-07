<?php
/* @var $this UserReviewsMarksController */
/* @var $data UserReviewsMarks */

$mark = UserReviewsMarks::model()->findByAttributes(array(
    'author_id' => Yii::app()->user->id,
    'review_id' => $review->id
));

if ($mark)
    $class = 'review-mark marked';
else
    $class = 'review-mark';
?>

    <a href="#" class="<?= $class ?>" data-id="<?= $review->id ?>" data-url="<?= Yii::app()->createAbsoluteUrl('/user/userReviewsMarks/mark'); ?>">
        <span class="thumbs"><span class="marks-count"><?= count($review->marks); ?></span> <i class="fa fa-thumbs-o-up"></i></span>
        <span class="unmarked-label"><?= Yii::t('app', 'mark as helpful') ?></span>
        <span class="marked-label"><?= Yii::t('app', 'marked as helpful') ?></span>
    </a>