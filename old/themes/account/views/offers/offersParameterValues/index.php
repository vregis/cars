<?php

    $this->pageTitle = Yii::t('app', 'Offer Parameters').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'My Offers') => array('/offers/default/index'),
        Yii::t('app', 'Offer #').$offer->id => array('/offers/default/edit', 'id' => $offer->id),
        Yii::t('app', 'Offer Parameters')
    );
    
    echo $this->renderPartial('/default/_tabs', array('model'=>$offer));
?>

    <div class="account-content">        
        <form action="" method="POST">
            <?php 
            if (!empty($groupedParameters)) 
                foreach ($groupedParameters as $group_id => $parameters) {
                    echo '<h3>'.Yii::t('app', $parameters[0]->group->name).'</h3>';

                    echo '<div class="row">';
                    $this->renderPartial('_colview', array('parameters' => $parameters, 'offer' => $offer, 'errors' => $errors, 'col' => 0));
                    $this->renderPartial('_colview', array('parameters' => $parameters, 'offer' => $offer, 'errors' => $errors, 'col' => 1));
                    echo '</div>';
                }
            
            echo CHtml::hiddenField('next', 1);
            ?>
            
            <br />
            <div class="form-group">
                <?php
                if (isset($_GET['master']) || ($offer->status == Offers::STATUS_PASSIVE))
                    echo '<button class="btn btn-success pull-right" type="submit">'.Yii::t('app', 'Save & Continue').' <i class="fa fa-angle-right"></i></button>';
                else
                    echo '<button class="btn btn-success" type="submit">'.Yii::t('app', 'Save').'</button>';
                ?>
            </div>
        </form>
    </div>