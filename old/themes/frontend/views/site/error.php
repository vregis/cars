<?php    
    $this->pageTitle = Yii::t('app', 'Error').' '.$error['code'].' | '.Yii::app()->name;
    
    $this->breadcrumbs = array(
        Yii::t('app', 'Error').' '.$error['code']
    );
    
    //CVarDumper::dump($error, 10, true);
    //exit();
?> 

    <div class="container">
        <h3 class="text-center"><?= Yii::t('app', 'Error').' '.$error['code'] ?>: <?= $error['message'] ?></h3>
        <br />
        <p class="lead text-center"><br /><?= Yii::t('app', 'Page not found.<br />It may be moved or deleted.') ?></p>

        <p class="text-center">
            <br /><br />
            <?php echo CHtml::link(Yii::t('app', 'Go to Home'), array('/site/index'), array('class'=>'btn btn-sm btn-success'));?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo CHtml::link(Yii::t('app', 'Open Sitemap'), array('/site/sitemap'), array('class'=>'btn btn-sm btn-default'));?>
            <br /><br /><br />
        </p>
    </div>