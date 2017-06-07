<?php
    $this->pageTitle = Yii::t('app', 'Archived Offers').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'Archived Offers')
    );
?>

    <div class="account-content">
    
        <h3><?= Yii::t('app', 'Archived Offers') ?></h3>
        
        <?php
        $this->widget('application.components.widgets.feListView', array(
            'dataProvider'=>$model->archivedSearch(),
            'itemView'=>'_view',
            'emptyText'=>Yii::t('app', 'No results found.')
        ));        
        ?>
    </div>