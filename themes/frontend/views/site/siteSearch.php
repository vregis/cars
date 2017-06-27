<?php    
    $this->pageTitle = Yii::t('app', 'Search').' | '.Yii::app()->name;
    
    $this->breadcrumbs = array(
        Yii::t('app', 'Search')
    );

    $model = new Offers();
?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-11 col-sm-offset-2">

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
               <!-- <div class="row">
                    <div class="col-xs-12 col-sm-9">
                        <?= CHtml::textField('s',$s,array('class'=>'form-control', 'placeholder'=>Yii::t('app', 'Paris, France'), 'autocomplete'=>'off', 'id'=>'search-location')); ?>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <?= CHtml::link(Yii::t('app', 'Search'), '#', array('class' => 'btn btn-default btn-submit', 'data-target' => 'main-site-search')) ?>       
                    </div>
                </div>-->
            <?php $this->endWidget(); ?>

            <form class="form-inline">
                <div class="row">
                    <div class="form-group col-xs-6">
                        <div class="col-xs-3">
                            <label class="margin-label" for="exampleInputName2">Location</label>
                        </div>
                        <div class="col-xs-9">
                        <input type="text" class="form-control width100" name="l" id="home-search-input" placeholder="<?= Yii::t('app', 'Paris, France') ?>" autocomplete="off" placeholder="Jane Doe">
                        </div>
                    </div>
                    <div class="form-group col-xs-6">
                        <div class="col-xs-3">
                            <label class="margin-label"  for="exampleInputEmail2">String</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="email" class="form-control width100" id="" placeholder="jane.doe@example.com">
                        </div>
                    </div>
                </div>
                <div style="margin-top:20px;" class="row">
                    <div style="text-align:right;" class="form-group col-xs-6">
                        <div class="col-xs-3"></div>
                        <div class="col-xs-9">
                            <div class="checkbox" style="margin-right:-11px">
                                <label>
                                    <b>North</b> <input type="checkbox">
                                </label>
                                <label>
                                    <b>Center</b> <input type="checkbox">
                                </label>
                                <label>
                                    <b>South</b> <input type="checkbox">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xs-6">
                        <div class="col-sm-3">
                            <label class="margin-label"  for="exampleInputEmail2">Age</label>
                        </div>
                        <div class="col-sm-9">

                        <div class="col-sm-1 no-paddings">

                            <?php

                            echo $form->textField($model,'age_from',array(
                                'id'=>'age_from',
                                'onkeyup'=>'$(\'#slider_range_slider\').slider(\'values\', 0, $(this).val());',
                                'class'=>'form-control small-slider',
                            ));
                            ?>

                        </div>
                        <div class="col-sm-10">

                            <?php
                            $this->widget('zii.widgets.jui.CJuiSliderInput', array(
                                'name'=>'slider_range',
                                'event'=>'change',
                                'options'=>array(
                                    //'range'=>true,
                                    'values'=>array(18,40),// default selection
                                    'min'=>0, //minimum value for slider input
                                    'max'=>120, // maximum value for slider input
                                    'animate'=>false,
                                    // on slider change event
                                    'slide'=>'js:function(event,ui){$(\'#age_from\').val(ui.values[0]); $(\'#age_to\').val(ui.values[1]);}',
                                ),
                                // slider css options
                                'htmlOptions'=>array(
                                    'style'=>'margin-top:20px;margin-bottom:20px; width:260px; margin-left:10px'
                                ),
                            ));
                            ?>

                        </div>
                        <div class="col-sm-1 no-paddings">

                            <?php
                            //echo $form->labelEx($model,'age_to');
                            echo $form->textField($model,'age_to',array(
                                'id'=>'age_to',
                                'onkeyup'=>'$(\'#slider_range_slider\').slider(\'values\', 1, $(this).val());',
                                'class'=>'form-control, small-slider'
                            ));
                            ?>

                        </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px">
                    <div class="form-group col-xs-6">
                        <div class="col-xs-3">
                            <label class="margin-label" for="exampleInputName2">Category</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="form-control width100" name="l" id="home-search-input" placeholder="" autocomplete="off" placeholder="Jane Doe">
                        </div>
                    </div>
                    <div class="form-group col-xs-6">
                        <div class="col-xs-3">
                        </div>
                        <div class="col-xs-9">
                                <p class="star-rating-small search-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i></p>
                            </div>
                    </div>
                </div>
            </form>

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

<script>
    $(document).on('click', '.fa-star-o', function(){
        $(this).removeClass('fa-star-o').addClass('fa-star');
    })
    $(document).on('click', '.fa-star', function(){
        $(this).removeClass('fa-star').addClass('fa-star-o');
    })
</script>


    

    