<?php    
    $this->pageTitle = Yii::t('app', 'Search').' | '.Yii::app()->name;
    
    $this->breadcrumbs = array(
        Yii::t('app', 'Search')
    );
?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2">

            <!-- Search Block -->   
            <?php $form=$this->beginWidget('CActiveForm', array(
                'action' => array('/site/siteSearch'),
                'clientOptions' => array(
                    'errorCssClass' => 'has-error',
                ),
                'method'=>'GET',
                'id'=>'main-site-search',
                'enableClientValidation' => true,
                'htmlOptions' => array(
                    'class'=>'form-horizontal info-block',
                )
            )); ?>  
                <div class="row">
                    <div class="col-xs-12 col-sm-9">
                        <?= CHtml::textField('s',$s,array('class'=>'form-control', 'placeholder'=>Yii::t('app', 'Paris, France'), 'autocomplete'=>'off', 'id'=>'search-location')); ?>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <?= CHtml::link(Yii::t('app', 'Search'), '#', array('class' => 'btn btn-default btn-submit', 'data-target' => 'main-site-search')) ?>       
                    </div>
                </div>
            <?php $this->endWidget(); ?>
    
            <div class="info-block">
                <h5>Search Results:</h5>
                
                <?php
                if (!empty($pages))
                    foreach ($pages as $page) {
                        $this->renderPartial('//staticPages/default/_search', array('data' => $page));
                    }
                ?>
            </div>
    
        </div>
    </div>
</div>

    

    