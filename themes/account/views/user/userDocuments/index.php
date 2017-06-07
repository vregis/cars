<?php
    $this->pageTitle = Yii::t('app', 'My Documents').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Profile') => array('/user/profile/edit'),
        Yii::t('app', 'My Documents')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'My Documents') ?></h3>
        
        <?php
            echo '<p class="text-right">'.CHtml::link(Yii::t('app', '+ Add document'), array('add', 'id'=>$model->user_id), array('class'=>'btn btn-success text-right')).'</p>';
            
            $this->renderPartial('gridview', array('model'=>$model));    
        ?>
    </div>