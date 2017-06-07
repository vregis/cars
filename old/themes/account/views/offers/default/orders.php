<?php
    $this->pageTitle = Yii::t('app', 'Clients\' Orders').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'Profile Edit') => array('/user/profile/edit'),
        Yii::t('app', 'Clients\' Orders')
    );
    
    $account_menu = array(
        array(
            'label' => 'Actual Offers',
            'url' => array('/offers/default/index'),
        ),
        array(
            'label' => 'Clients\' Orders',
            'url' => array('/offers/default/orders'),
        ),
        array(
            'label' => 'Archived Offers',
            'url' => array('/offers/default/archived'),
        ),
    );
    
    $this->widget('zii.widgets.CMenu',array(
        'encodeLabel'=>false,
        'items'=>$account_menu,
        'htmlOptions'=>array('class' => 'nav nav-tabs'),
    ));
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Clients\' Orders') ?></h3>
        
        <?php
        $this->renderPartial('orders_grid', array('model'=>$model));     
        ?>
    </div>