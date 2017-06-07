<?php
    $this->pageTitle = Yii::t('app', 'Archived Orders').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'Archived Orders')
    );
?>

    <div class="account-content">
        
        <h3><?= Yii::t('app', 'Archived Orders') ?></h3>
        
        <?php
        $this->renderPartial('_archivedgrid', array('model'=>$model));     
        ?>
    </div>