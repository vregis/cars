<?php
    $this->pageTitle = Yii::t('app', 'Active Offers').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers')
    );
?>

    <div class="account-content">
        <h3><?= Yii::t('app', 'Active Offers') ?></h3>
        
        <?php
            echo '<p class="text-right">'.CHtml::link(Yii::t('app', '+ Add new offer'), array('add'), array('class'=>'btn btn-success text-right')).'</p>';
            
            $this->widget('application.components.widgets.feListView', array(
                'dataProvider'=>$model->frontendSearch(),
                'itemView'=>'_view',
                'emptyText'=>Yii::t('app', 'No results found.')
            ));        
        ?>
    </div>