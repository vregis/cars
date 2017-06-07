<?php
    
$this->breadcrumbs = array(
    Yii::t('app', 'Stories') => array('/articles/default/index'),
    $model->title
);

if (empty($model->meta_title))
    $this->pageTitle = $model->title.' — '.Yii::app()->name;
else
    $this->pageTitle = $model->meta_title;

if (empty($model->meta_description))
    Yii::app()->clientScript->registerMetaTag($this->pageTitle, 'description');
else
    Yii::app()->clientScript->registerMetaTag($model->meta_description, 'description');

if (empty($model->meta_keywords))
    Yii::app()->clientScript->registerMetaTag($this->pageTitle, 'keywords');
else
    Yii::app()->clientScript->registerMetaTag($model->meta_keywords, 'keywords');    
?>

    <div class="article-pi-container" style="background-image: url(<?= Yii::app()->request->hostInfo.'/resources/articles/'.$model->image ?>);"></div>
        
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <h1><?php echo $model->title; ?></h1>
                <div style="width: 200px;">
                        <?php echo SiteVars::v('LIKES_DISPLAY'); ?>
                </div>
                <?php echo $model->annotation; ?>
                <?php echo $model->text; ?>
                <?php echo SiteVars::v('COMMENTS_CACLE'); ?>
                <p class="text-muted text-right"><em>--<br /><?= Yii::t('app', 'Published on') ?> <?php echo Yii::app()->locale->dateFormatter->format(Yii::t('app', 'd MMMM yyyy'), $model->date_created); ?></em></p>
                <hr />
                <div class="col-xs-12 col-sm-4">
                    
                </div>
                <div class="text-right">
                    <?php echo CHtml::link(Yii::t('app', 'Back to articles').' <i class="fa fa-angle-right"></i>', array('/articles/default/index'), array('class' => 'btn btn-muted')); ?>
                </div>
            </div>
        </div>
    </div>