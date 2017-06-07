<?php
    /* @var $this OfferAddressesController */
    /* @var $model OfferAddresses */

    $this->pageTitle = Yii::t('app', 'My Addresses').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'My Addresses')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'My Addresses') ?></h3>
        <br />
        
        <?php
            echo '<p class="text-right">'.CHtml::link(Yii::t('app', '+ Add new address'), array('add'), array('class'=>'btn btn-success text-right')).'</p>';
            
            $this->renderPartial('indexgrid', array('model'=>$model));     
        ?>
    </div>