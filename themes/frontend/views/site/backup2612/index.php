  

        <!-- Home search -->
        <div id="home-search">
            <div id="home-search-bg">
                <div class="home-search-cover hidden-xs" style="background-image: url(<?= SiteVars::v('HOME_PROMO_AIR') ?>);">
                    <a href="/s?t=3">
                        <video muted loop>
                            <source src="resources/articles/11680844.mp4" type="video/mp4">
                        </video>
                    </a>
                </div>
            </div>
            <div class="container text-center">
                <h1 class="display-inblock">&nbsp;</h1><br />
                <p class="display-inblock">&nbsp;</p>
                <div class="row text-left">
                    <div class="col-xs-12 col-md-8 col-md-offset-2">
                        
                         <form class="form-inline" action="<?php echo Yii::app()->createUrl('/site/search'); ?>" method="GET" id="home-search-form">
                        <div class="input-group">
                            <span class="input-group-addon hidden-xs"><?= Yii::t('app', 'Location') ?></span>
                            <input type="text" name="l" id="home-search-input" placeholder="<?= Yii::t('app', 'Paris, France') ?>" autocomplete="off">
                            <span class="input-group-addon hidden-xs"><?= Yii::t('app', 'Category') ?></span>
                            <input type="text" name="" id="" data-single="0" class='catdd-selector' placeholder="<?= Yii::t('app', 'Category, Auto') ?>" autocomplete="off">
                            <input id="search-type"  class="form-control" autocomplete="off" empty="Select category..." value="" name="t" type="hidden">
                            <span class="input-group-addon  hidden-xs"><?= Yii::t('app', 'String') ?></span>
                            <input type="text" name="st" id="home-search-input-string" placeholder="<?= Yii::t('app', 'Paris, France') ?>" autocomplete="off">
                            <span class="input-group-btn">
                                <button class="btn" type="submit"><i class="fa fa-search fa-before"></i>Go!</button>
                            </span>
                        </div>
                            <ul id="home-search-results">
                                <li class="first"><?= Yii::t('app', 'Search results') ?>:</li>
                            </ul>
                        </form>
                    </div>  
                </div>  
            </div>  
        </div>  
        
        <h1 class="home-superinfo"><?= Yii::t('app', 'Smart way to Rent a Vehicle') ?></h1>
        <p class="home-superinfo"><?= Yii::t('app', 'Best offers from owners all over the world') ?></p>
        
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

<div class="categories-dropdown-litter"></div>    
        <!-- End of Experiment  -->

        <!-- Top Promo -->

        <?php
        if (Yii::app()->user->isGuest) {
        ?>
        <div class="container">
            <div class="row info-block">
                <div class="col-xs-12 col-sm-3 col-sm-offset-2">
                    <?php echo CHtml::link('Become an Owner <i class="fa fa-angle-right"></i>', array('/user/registration/registration'), array('class' => 'btn btn-success pull-right')); ?>
                </div>
                <div class="col-xs-12 col-sm-3 col-sm-offset-2">
                    <?php echo CHtml::link('How It Works <i class="fa fa-angle-right"></i>', array('/staticPages/default/view', 'url_name' => 'how-it-works'), array('class' => 'btn btn-info')); ?>
                </div>
            </div>  
        </div>
        <?php
        }
        ?>
        
        <!-- Quick Search 
        <div class="info-block">
            <hr />
            <div class="container">
                <form action="<?php //echo Yii::app()->createUrl('/site/search'); ?>" method="GET" class="row" id="home-quick-search">  
                    <div class="col-xs-12 col-md-3 col-lg-2">
                        <h3>Quick Search:</h3>
                    </div>    
                    <div class="col-xs-12 col-md-3 col-lg-4">
                        <?php //echo CHtml::dropDownList('type', '', Categories::model()->getListDataGrouped(), array('class' => 'form-control selectpicker', 'empty' => 'Select category...')); ?>
                    </div>   
                    <div class="col-xs-12 col-md-3 col-lg-4">
                        <span class="date-icon"><i class="fa fa-calendar"></i></span><input type="text" name="p" placeholder="Set actual dates..." class="form-control daterangepicker">
                    </div>   
                    <div class="col-xs-12 col-md-3 col-lg-2">
                        <a href="#" class="btn btn-muted btn-submit"><i class="fa fa-search fa-before"></i> Search</a>
                    </div>  
                </form>  
            </div>  
            <hr />
        </div>  --> 
        
        <!-- Top Promo -->   
        <div class="container">
        <script type="text/javascript">(function(w,doc) {
if (!w.__utlWdgt ) {
    w.__utlWdgt = true;
    var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
}})(window,document);
</script>
<div data-background-alpha="0.0" data-buttons-color="#FFFFFF" data-counter-background-color="#ffffff" data-share-counter-size="12" data-top-button="false" data-share-counter-type="common" data-share-style="1" data-mode="share" data-like-text-enable="false" data-mobile-view="true" data-icon-color="#ffffff" data-orientation="fixed-right" data-text-color="#000000" data-share-shape="round-rectangle" data-sn-ids="fb.vk.tw.ok." data-share-size="30" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.vb." data-pid="1616832" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="false" data-selection-enable="true" class="uptolike-buttons" ></div>
            <div class="row info-block">
                <div class="col-xs-12 home-categories-preview">
                    <h1 class="text-center zero-header">Explore new horizons</h1>
                    <p class="text-center">See what tourists actually use to achieve new impression, all over the world.</p>
                </div>  
                <?php
                if (!empty($promoted))
                    foreach ($promoted as $offer) {
                    if (empty($offer->primaryPhoto)) continue;
                     
                ?>
                <div class="col-xs-12 col-md-4 home-categories">
                    <?php
                        echo CHtml::image(
                                Yii::app()->request->hostInfo.'/resources/offers/400_'.$offer->primaryPhoto->filename, 
                                $offer->title, array('class' => 'img-responsive')); 
                    ?>
                    <div>
                        <h4><?= $offer->title ?></h4>
                        <p>&nbsp;</p>
                        <p><?php
                            $addresses = $offer->addresses;
                            if (!empty($addresses)) {
                                $address = $addresses[0];
                                $addr_parts = array();
                                if (!empty($address->city)) $addr_parts[] = $address->city;
                                if (!empty($address->country->name)) $addr_parts[] = $address->country->name;
                                echo CHtml::link(implode(', ', $addr_parts), array('/offers/default/view', 'id' => $offer->id)); 
                            }
                        ?></p>
                    </div>
                </div>                
                <?php                        
                    }
                ?>
            </div>  
        </div>  
        
        <!-- Bundles Block -->   
        <div id="mountains-bg">
            <div class="container">
                <div class="row info-block">
                    <div class="col-xs-12 col-md-7 col-md-offset-1">
                        <h2 class="text-success half-header">Get ready: new Big Story comes!</h2>
                        <p class="small-lead">The movement of the rotor requires more attention to the analysis of errors that gives the pitch. However, the study of the problem in a more rigorous formulation shows that the integral of variable integrates the moment.</p>
                        <p class="small-lead">The angular velocity of the gyroscopic effect on the components of the moment more than a resonance angular momentum of its own in accordance with the system of equations.</p>
                        <p><br /><?= CHtml::link('Get more info <i class="fa fa-angle-right"></i>', array('/articles/default/index'), array('class' => 'btn btn-success')) ?><br /><br /></p>
<script type="text/javascript">(function(w,doc) {
if (!w.__utlWdgt ) {
    w.__utlWdgt = true;
    var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
}})(window,document);
</script>
<div data-background-alpha="0.0" data-orientation="horizontal" data-text-color="#000000" data-share-shape="SHARP" data-buttons-color="#FFFFFF" data-sn-ids="fb.vk.ok." data-counter-background-color="#ffffff" data-share-size="LARGE" data-background-color="#ffffff" data-mobile-sn-ids="fb.vk.ok." data-preview-mobile="false" data-pid="1616837" data-counter-background-alpha="1.0" data-mode="like" data-following-enable="false" data-exclude-show-more="false" data-like-text-enable="false" data-selection-enable="true" data-mobile-view="true" data-icon-color="#ffffff" class="uptolike-buttons" ></div>
                        <div class="row">
                            <div class="col-m-12 col-sm-8 col-sm-offset-4">
                                <p class="small-lead">The consumer society allows convergent reach. Changing global strategy reverses the strategic product placement. Behavioral Targeting multifaceted organizes a popular advertising brief.</p>
                                <p class="small-lead">Building a brand is concentrating convergent ad unit, gaining market segment. Youth audience specifies booth, increasing competition. CTR attracted enough daily ranking.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 hidden-xs hidden-sm col-sm-4"> 
                        <?php echo CHtml::image(Yii::app()->request->hostInfo.'/resources/articles/home-bundles.jpg', '', array('class' => 'img-responsive')); ?>
                    </div>
                </div> 
                
                <div class="row info-block">
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1">
                        <div class="home-areas-cover">
                            <div class="home-areas">
                                <?php echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/img/home-ground.jpg', '', array('class' => 'img-responsive')), array('#')); ?>
                                <div>
                                    <i class="fa fa-bicycle"></i>
                                    <h4>Ground</h4>
                                    <p>cars, bikes, bicycles</p>
                                </div>
                            </div>
                            <?php
                                $ground_articles = Articles::model()->findAll(array('select' => 'category_id, url_name, annotation', 'condition' => 'category_id = 0'));
                                shuffle($ground_articles);
                                if (!empty($ground_articles[0])) {
                                    $ground_article = $ground_articles[0];
                                    echo '<p>'.mb_substr(strip_tags($ground_article->annotation), 0, 128, 'UTF-8').'...</p>';
                                    echo '<p class="text-right">'.CHtml::link(Yii::t('app', 'Read more...'), array('/articles/default/view', 'url_name' => $ground_article->url_name)).'</p>';
                                }
                            ?>
                            <p><?= CHtml::link('Set location & Search', array('/articles/default/featured', 'id' => 'ground'), array('class' => 'btn btn-success btn-block')) ?></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1">
                        <div class="home-areas-cover">
                            <div class="home-areas">
                                <?php echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/img/home-water.jpg', '', array('class' => 'img-responsive')), array('#')); ?>
                                <div>
                                    <i class="fa fa-ship"></i>
                                    <h4>Water</h4>
                                    <p>ships, speed-boats</p>
                                </div>
                            </div>
                            <?php
                                $water_articles = Articles::model()->findAll(array('select' => 'category_id, url_name, annotation', 'condition' => 'category_id = 1'));
                                shuffle($water_articles);
                                if (!empty($water_articles[0])) {
                                    $water_article = $water_articles[0];
                                    echo '<p>'.mb_substr(strip_tags($water_article->annotation), 0, 128, 'UTF-8').'...</p>';
                                    echo '<p class="text-right">'.CHtml::link(Yii::t('app', 'Read more...'), array('/articles/default/view', 'url_name' => $water_article->url_name)).'</p>';
                                }
                            ?>
                            <p><?= CHtml::link('Set location & Search', array('/articles/default/featured', 'id' => 'water'), array('class' => 'btn btn-success btn-block')) ?></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1">
                        <div class="home-areas-cover">
                            <div class="home-areas">
                                <?php echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/img/home-air.jpg', '', array('class' => 'img-responsive')), array('#')); ?>
                                <div>
                                    <i class="fa fa-plane"></i>
                                    <h4>Air</h4>
                                    <p>planes, gliders</p>
                                </div>
                            </div>
                            <?php
                                $air_articles = Articles::model()->findAll(array('select' => 'category_id, url_name, annotation', 'condition' => 'category_id = 2'));
                                shuffle($air_articles);
                                if (!empty($air_articles[0])) {
                                    $air_article = $air_articles[0];
                                    echo '<p>'.mb_substr(strip_tags($air_article->annotation), 0, 128, 'UTF-8').'...</p>';
                                    echo '<p class="text-right">'.CHtml::link(Yii::t('app', 'Read more...'), array('/articles/default/view', 'url_name' => $air_article->url_name)).'</p>';
                                }
                            ?>                            
                            <p><?= CHtml::link('Set location & Search', array('/articles/default/featured', 'id' => 'air'), array('class' => 'btn btn-success btn-block')) ?></p>
                        </div>
                    </div>
                </div> 
            </div>   
        </div>  