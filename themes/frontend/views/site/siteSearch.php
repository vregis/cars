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

            <form class="form-inline" action="/s" method="GET">
                <div class="row">
                    <div class="form-group col-xs-6">
                        <div class="col-xs-3">
                            <label class="margin-label"  for="exampleInputEmail2">String</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="email" name="email" class="form-control width100" id="" placeholder="jane.doe@example.com">
                        </div>
                    </div>
                    <div class="form-group col-xs-6">
                        <div class="col-xs-3">
                            <label class="margin-label" for="exampleInputName2">Category</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" data-single="0" autocomplete="off" name="category" class="form-control width100 catdd-selector">
                        </div>
                    </div>
                </div>
                <div style="margin-top:20px;" class="row">

                    <!-- Expperimental part Roman -->
                    <div class="search-type-container animated">
                        <div class="container">
                            <div class="content-block">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#earth" aria-controls="earth" role="tab" data-toggle="tab">
                                            <?= CHtml::image(Yii::app()->theme->baseUrl.'/img/home-ground-sq.jpg', Yii::t('app', 'Earth'), array('class' => 'img-circle')) ?>
                                            <?= Yii::t('app', 'Earth'); ?>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#water" aria-controls="water" role="tab" data-toggle="tab">
                                            <?= CHtml::image(Yii::app()->theme->baseUrl.'/img/home-water-sq.jpg', Yii::t('app', 'Water'), array('class' => 'img-circle')) ?>
                                            <?= Yii::t('app', 'Water'); ?>
                                        </a></li>
                                    <li role="presentation">
                                        <a href="#air" aria-controls="air" role="tab" data-toggle="tab">
                                            <?= CHtml::image(Yii::app()->theme->baseUrl.'/img/home-air-sq.jpg', Yii::t('app', 'Air'), array('class' => 'img-circle')) ?>
                                            <?= Yii::t('app', 'Air'); ?>
                                        </a></li>
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="earth">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-4">
                                                <?php
                                                $top_categories = Categories::getListDataWithoutChildren(1);

                                                $this->widget('zii.widgets.CMenu',array(
                                                    'encodeLabel'=>false,
                                                    'firstItemCssClass'=>'first',
                                                    'items'=>$top_categories,
                                                    'htmlOptions'=>array('class' => 'topcategories'),
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <?php
                                                $all_subcategories = array();
                                                if (!empty($top_categories))
                                                    foreach ($top_categories as $category) {
                                                        $id = $category['linkOptions']['data-id'];
                                                        $second_categories = Categories::getListDataWithoutChildren($id);

                                                        $this->widget('zii.widgets.CMenu',array(
                                                            'id'=>'subcats-'.$id,
                                                            'encodeLabel'=>false,
                                                            'firstItemCssClass'=>'first',
                                                            'items'=>$second_categories,
                                                            'htmlOptions'=>array('class' => 'subcategories'),
                                                        ));

                                                        $all_subcategories = array_merge($all_subcategories, $second_categories);
                                                    }
                                                ?>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <?php
                                                if (!empty($all_subcategories))
                                                    foreach ($all_subcategories as $category) {
                                                        $id = $category['linkOptions']['data-id'];
                                                        $second_categories = Categories::getListDataWithoutChildren($id);

                                                        $this->widget('zii.widgets.CMenu',array(
                                                            'id'=>'subcats-'.$id,
                                                            'encodeLabel'=>false,
                                                            'firstItemCssClass'=>'first',
                                                            'items'=>$second_categories,
                                                            'htmlOptions'=>array('class' => 'subcategories'),
                                                        ));
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="water">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-4">
                                                <?php
                                                $top_categories = Categories::getListDataWithoutChildren(2);

                                                $this->widget('zii.widgets.CMenu',array(
                                                    'encodeLabel'=>false,
                                                    'firstItemCssClass'=>'first',
                                                    'items'=>$top_categories,
                                                    'htmlOptions'=>array('class' => 'topcategories'),
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <?php
                                                $all_subcategories = array();
                                                if (!empty($top_categories))
                                                    foreach ($top_categories as $category) {
                                                        $id = $category['linkOptions']['data-id'];
                                                        $second_categories = Categories::getListDataWithoutChildren($id);

                                                        $this->widget('zii.widgets.CMenu',array(
                                                            'id'=>'subcats-'.$id,
                                                            'encodeLabel'=>false,
                                                            'firstItemCssClass'=>'first',
                                                            'items'=>$second_categories,
                                                            'htmlOptions'=>array('class' => 'subcategories'),
                                                        ));

                                                        $all_subcategories = array_merge($all_subcategories, $second_categories);
                                                    }
                                                ?>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <?php
                                                if (!empty($all_subcategories))
                                                    foreach ($all_subcategories as $category) {
                                                        $id = $category['linkOptions']['data-id'];
                                                        $second_categories = Categories::getListDataWithoutChildren($id);

                                                        $this->widget('zii.widgets.CMenu',array(
                                                            'id'=>'subcats-'.$id,
                                                            'encodeLabel'=>false,
                                                            'firstItemCssClass'=>'first',
                                                            'items'=>$second_categories,
                                                            'htmlOptions'=>array('class' => 'subcategories'),
                                                        ));
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="air">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-4">
                                                <?php
                                                $top_categories = Categories::getListDataWithoutChildren(3);

                                                $this->widget('zii.widgets.CMenu',array(
                                                    'encodeLabel'=>false,
                                                    'firstItemCssClass'=>'first',
                                                    'items'=>$top_categories,
                                                    'htmlOptions'=>array('class' => 'topcategories'),
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <?php
                                                $all_subcategories = array();
                                                if (!empty($top_categories))
                                                    foreach ($top_categories as $category) {
                                                        $id = $category['linkOptions']['data-id'];
                                                        $second_categories = Categories::getListDataWithoutChildren($id);

                                                        $this->widget('zii.widgets.CMenu',array(
                                                            'id'=>'subcats-'.$id,
                                                            'encodeLabel'=>false,
                                                            'firstItemCssClass'=>'first',
                                                            'items'=>$second_categories,
                                                            'htmlOptions'=>array('class' => 'subcategories'),
                                                        ));

                                                        $all_subcategories = array_merge($all_subcategories, $second_categories);
                                                    }
                                                ?>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <?php
                                                if (!empty($all_subcategories))
                                                    foreach ($all_subcategories as $category) {
                                                        $id = $category['linkOptions']['data-id'];
                                                        $second_categories = Categories::getListDataWithoutChildren($id);

                                                        $this->widget('zii.widgets.CMenu',array(
                                                            'id'=>'subcats-'.$id,
                                                            'encodeLabel'=>false,
                                                            'firstItemCssClass'=>'first',
                                                            'items'=>$second_categories,
                                                            'htmlOptions'=>array('class' => 'subcategories'),
                                                        ));
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr />

                                <div class="row">
                                    <div class="col-xs-12 col-sm-9">
                                        <ul id="selected-types">
                                            <li><?= Yii::t('app', 'Selected types') ?>:</li>
                                            <?php
                                            if (!empty($_GET['t'])) {
                                                $types = explode(',',$_GET['t']);

                                                if (!empty($types)) {
                                                    $criteria = new CDbCriteria();
                                                    $criteria->addInCondition('id', $types);
                                                    $selected_categories = Categories::model()->findAll($criteria);

                                                    if (!empty($selected_categories))
                                                        foreach ($selected_categories as $category) {
                                                            echo '<li data-id="'.$category->id.'"><a href="#">'.$category->name.'<i class="fa fa-times"></i></a></li>';
                                                        }
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <a href="#" class="btn btn-success btn-block btn-accept-types"><?= Yii::t('app', 'Apply selection'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="categories-dropdown-litter"></div>
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
                    <div class="form-group col-xs-6">
                        <div class="col-xs-3">
                        </div>
                        <div class="col-xs-9">
                            <input name="s" type="hidden" class="rating-input" value="">
                            <p class="star-rating-small search-rating">
                                <i data-number="1" class="fa fa-star star-rat"></i>
                                <i data-number="2" class="fa fa-star-o star-rat"></i>
                                <i data-number="3" class="fa fa-star-o star-rat"></i>
                                <i data-number="4" class="fa fa-star-o star-rat"></i>
                                <i data-number="5" class="fa fa-star-o star-rat"></i></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-6"></div>
                    <div class="form-group col-xs-6">
                        <input style="margin-left:16px" type="submit" value="Search offers" class="btn">
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

    $('input#age_to').attr('name', 'age_to');
    $('input#age_from').attr('name', 'age_from');

    $(document).on('click', '.star-rat', function(){
        var num = $(this).attr('data-number');

        $('.fa-star').each(function(){

            $('.rating-input').val(num);
            $(this).removeClass('fa-star').addClass('fa-star-o');
            $('.star-rat').each(function(){
                if($(this).attr('data-number') <= num ){
                    $(this).removeClass('fa-star-o').addClass('fa-star')
                }
            })
        })
    })

</script>


    

    