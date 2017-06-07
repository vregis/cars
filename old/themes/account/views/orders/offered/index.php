<?php
    $this->pageTitle = Yii::t('app', 'Clients\' Orders').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'Orders Schedule')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Orders Schedule') ?></h3>
        
        <?php
        $this->renderPartial('indexgrid', array('model'=>$model));     
        ?>
    </div>