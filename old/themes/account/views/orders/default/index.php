<?php
    $this->pageTitle = Yii::t('app', 'Active Orders').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Orders')
    );
    
    $account_menu = array(
        array(
            'label' => 'Actual '.((Orders::countMyByStatus(Orders::STATUS_NEW))?('[ '.Orders::countMyByStatus(Orders::STATUS_NEW).' ]'):('')),
            'url' => array('/orders/default/index'),
            'active' => (!isset($_GET['t']) || ($_GET['t'] == Orders::STATUS_NEW)),
        ),
        array(
            'label' => 'Submitted '.((Orders::countMyByStatus(Orders::STATUS_SUBMITTED))?('[ '.Orders::countMyByStatus(Orders::STATUS_SUBMITTED).' ]'):('')),
            'url' => array('/orders/default/index', 't' => Orders::STATUS_SUBMITTED),
        ),
        array(
            'label' => 'For payment '.((Orders::countMyByStatus(Orders::STATUS_PAYMENT))?('[ '.Orders::countMyByStatus(Orders::STATUS_PAYMENT).' ]'):('')),
            'url' => array('/orders/default/index', 't' => Orders::STATUS_PAYMENT),
        ),
        array(
            'label' => 'Ordered '.((Orders::countMyByStatus(Orders::STATUS_APPROVED))?('[ '.Orders::countMyByStatus(Orders::STATUS_APPROVED).' ]'):('')),
            'url' => array('/orders/default/index', 't' => Orders::STATUS_APPROVED),
        ),
    );
    
    $this->widget('zii.widgets.CMenu',array(
        'encodeLabel'=>false,
        'items'=>$account_menu,
        'htmlOptions'=>array('class' => 'nav nav-tabs'),
    ));
?>

    <div class="account-content">
        <?php
        if (!isset($_GET['t']) || ($_GET['t'] == Orders::STATUS_NEW)) {
            echo '<h3>'.Yii::t('app', 'Actual Orders').'</h3>';
            $status = array(Orders::STATUS_NEW);
        } elseif (isset($_GET['t']) && ($_GET['t'] == Orders::STATUS_SUBMITTED)) {
            echo '<h3>'.Yii::t('app', 'Submitted Orders').'</h3>';
            $status = array(Orders::STATUS_SUBMITTED);
        } elseif (isset($_GET['t']) && ($_GET['t'] == Orders::STATUS_PAYMENT)) {
            echo '<h3>'.Yii::t('app', 'Orders for payment').'</h3>';
            $status = array(Orders::STATUS_PAYMENT);
        } elseif (isset($_GET['t']) && ($_GET['t'] == Orders::STATUS_APPROVED)) {
            echo '<h3>'.Yii::t('app', 'Ordered Offers').'</h3>';
            $status = array(Orders::STATUS_APPROVED);
        }
        ?>
        
        
        <?php
        $this->widget('application.components.widgets.feListView', array(
            'dataProvider'=>$model->clientSearch($status),
            'itemView'=>'_view',
            'emptyText'=>Yii::t('app', 'No results found.')
        ));        
        ?>
    </div>