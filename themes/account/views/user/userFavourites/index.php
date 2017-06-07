<?php
    $this->pageTitle = Yii::t('app', 'My Favourites').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Profile') => array('/user/profile/edit'),
        Yii::t('app', 'My Favourites')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'My Favourites') ?></h3>
        
        <div class="row">
        <?php
        $this->widget('application.components.widgets.feListView', array(
            'dataProvider'=>$model->frontendSearch(),
            'itemView'=>'_view',
            'emptyText'=>Yii::t('app', 'No results found.')
        ));        
        ?>
        </div>
    </div>