<?php    
    $this->pageTitle = Yii::t('app', 'Search').' | '.Yii::app()->name;
    
    $this->breadcrumbs = array(
        Yii::t('app', 'Search')
    );
?>

        <!-- Search Block -->   
        <?php $form=$this->beginWidget('CActiveForm', array(
            'action' => array('/site/search'),
            'clientOptions' => array(
                'errorCssClass' => 'has-error',
            ),
            'method'=>'GET',
            'id'=>'main-search',
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'class'=>'form-horizontal',
            )
        )); ?>  
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="l" class="control-label col-xs-12 col-sm-4"><?= Yii::t('app', 'Location') ?> <span class="text-danger">*</span></label>
                            <div class="col-xs-12 col-sm-8">
                                <?= CHtml::textField('l',$model->location,array('class'=>'form-control', 'placeholder'=>Yii::t('app', 'Paris, France'), 'autocomplete'=>'off', 'id'=>'search-location')); ?>
                                <div id="location-results-cover">
                                    <ul id="home-search-results">
                                        <li class="first"><?= Yii::t('app', 'Search results') ?>:</li>
                                    </ul>
                                </div>
                            </div>
                        </div>       
                        <div class="form-group">
                            <label for="t" class="control-label col-xs-12 col-sm-4"><?= Yii::t('app', 'Type') ?></label>
                            <div class="col-xs-12 col-sm-8">
                                <?php
                                $this->widget('application.components.widgets.feCategoryDropdown', array(
                                    'name'=>'t',
                                    'value' => $model->type
                                ));
                                ?>
                            </div>
                        </div>                        
                    </div> 
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="age_from" class="control-label col-xs-2 col-sm-2">Age</label>
                            <div class="col-sm-2">
                                <?= 
                                    CHtml::textField('age_from',$model->age_from,array( 
                                        'id'=>'age_from',
                                        'onkeyup'=>'$(\'#slider_range_slider\').slider(\'values\', 0, $(this).val());',
                                        'class'=>'form-control'
                                    )); 
                                ?>
                            </div>
                            <div class="col-sm-2">
                                <?= 
                                    //echo $form->labelEx($model,'age_to');
                                    CHtml::textField('age_to',$model->age_to,array( 
                                            'id'=>'age_to',
                                            'onkeyup'=>'$(\'#slider_range_slider\').slider(\'values\', 1, $(this).val());',
                                            'class'=>'form-control'
                                        ));
                                ?>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                
                                    <?php 
                                        $this->widget('zii.widgets.jui.CJuiSliderInput', array(
                                        'name'=>'slider_range',
                                        'event'=>'change',
                                        'options'=>array(
                                        //'range'=>true,
                                        'values'=>array(0,120),// default selection
                                        'min'=>0, //minimum value for slider input
                                        'max'=>120, // maximum value for slider input
                                        'animate'=>false,
                                        // on slider change event
                                        'slide'=>'js:function(event,ui){$(\'#age_from\').val(ui.values[0]); $(\'#age_to\').val(ui.values[1]);}',
                                        ),
                                        // slider css options
                                        'htmlOptions'=>array(
                                        'style'=>'margin-top:20px;margin-bottom:20px;'
                                         ),
                                        ));
                                    ?>
                       
                            </div>
                        </div>
                    </div> 
                    <div class="col-xs-12 col-md-6">
                        <!-- <div class="form-group">
                            <label for="abc" class="control-label col-xs-12 col-sm-4"><?= Yii::t('app', 'Date Period') ?></label>
                            <div class="col-xs-12 col-sm-8">
                                <span class="date-icon"><i class="fa fa-calendar"></i></span><?= CHtml::textField('dd',((!empty($_GET['dd']))?($_GET['dd']):($model->date_since.' ~ '.$model->date_for)),array('class'=>'form-control daterangepicker', 'placeholder'=>Yii::t('app', 'Set actual dates...'), 'autocomplete'=>'off')); ?>
                            </div>
                        </div>     -->   
                        <div class="form-group">
                            <label for="abc" class="control-label col-xs-12 col-sm-4"><?= Yii::t('app', 'Rating') ?></label>
                            <div class="col-xs-12 col-sm-8">                                
                                <ul class="star-rating">
                                    <li data-value="1"><i class="fa fa-star-o"></i></li>
                                    <li data-value="2"><i class="fa fa-star-o"></i></li>
                                    <li data-value="3"><i class="fa fa-star-o"></i></li>
                                    <li data-value="4"><i class="fa fa-star-o"></i></li>
                                    <li data-value="5"><i class="fa fa-star-o"></i></li>
                                    <li class="star-result"><?= CHtml::hiddenField('s',$model->rating); ?> <?= Yii::t('app', '<span>all</span> offers') ?></li>
                                </ul>
                            </div>
                        </div>     
                    </div> 
                </div>   
                <div class="collapse<?= ((isset($_GET['po']) || isset($_GET['ap']))?(' in'):('')) ?>" id="advanced-search">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="abc" class="control-label col-xs-12 col-sm-4"><?= Yii::t('app', 'Only Privates') ?></label>
                                <div class="col-xs-12 col-sm-8">
                                    <?= CHtml::checkBox('po',$model->privates,array('class'=>'form-control icheck')) ?>
                                </div>
                            </div>                          
                        </div>  
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="abc" class="control-label col-xs-12 col-sm-4"><?= Yii::t('app', 'Approved') ?></label>
                                <div class="col-xs-12 col-sm-8">
                                    <?= CHtml::checkBox('ap',$model->approved,array('class'=>'form-control icheck')) ?>
                                </div>
                            </div>                     
                        </div>  
                    </div> 
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-6 col-md-offset-6">    
                        <div class="form-group">   
                            <div class="col-xs-12 col-sm-8 col-sm-offset-4">
                                <br />
                                <a href="#" class="btn btn-default btn-submit" data-target="main-search"><i class="fa fa-search fa-before"></i> <?= Yii::t('app', 'Find offers') ?></a>
                                <input type="reset" value="Reset search" class="btn btn-muted" data-target="main-search">
                                <input type="submit" style="display: none;">
                            </div>       
                        </div>       
                    </div>  
                </div>   
            </div>
            <div class="search-subbar">  
                <div class="container">
                    <div class="row">   
                        <div class="col-xs-12 col-sm-4 col-md-4 col-md-offset-2">
                            <a href="#advanced-search" class="more-options dashed" data-toggle="collapse" aria-expanded="false" aria-controls="advanced-search"><?= Yii::t('app', 'Get more search options') ?></a>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <?= CHtml::hiddenField('sort', $model->sort, array('id' => 'search-sort-value')) ?>
                            <span class="hidden-xs"><?= Yii::t('app', 'Sort Order') ?></span>
                            <a href="#" class="results-sort" data-type="rating" data-value="<?= (($model->sort & 2)?(2):(0)) ?>">by Rating <i class="fa fa-caret-<?= (($model->sort & 2)?('down'):('up')) ?>"></i></a>
                            <!--<a href="#" class="results-sort" data-type="distance" data-value="<?= (($model->sort & 4)?(4):(0)) ?>">by Distance <i class="fa fa-caret-<?= (($model->sort & 4)?('down'):('up')) ?>"></i></a>-->
                            <a href="#" class="results-sort" data-type="price" data-value="<?= (($model->sort & 8)?(8):(0)) ?>">by Price <i class="fa fa-caret-<?= (($model->sort & 8)?('down'):('up')) ?>"></i></a>
                        </div>
                    </div>                
                </div>                
            </div>
        <?php $this->endWidget(); ?>
        
        <div id="search-results-cover">
            <div id="search-map">
                <?php
                $this->widget('application.components.widgets.feMap', array(
                    'pins'=>$model->processMapPins($items),
                    'height' => 500,
                    'containerOptions' => array(
                        'style' => 'width: 100%' 
                    )
                ));
                ?>
            </div>
            <div id="search-results-list">
                <?php $this->renderPartial('/offers/default/_searchresults', array('items' => $items, 'pages' => $pages)); ?>
            </div>
        </div>