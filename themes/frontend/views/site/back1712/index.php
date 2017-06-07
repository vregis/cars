  

        <!-- Home search -->
        <div id="home-search">
            <div id="home-search-bg">
                <div class="home-search-cover hidden-xs" style="background-image: url(<?= SiteVars::v('HOME_PROMO_AIR') ?>);">
                    <a href="/s?t=3">
                        <video muted loop>
                            <source src="resources/articles/home-video-3.mp4" type="video/mp4">
                        </video>
                    </a>
                </div>
            </div>
            <div class="container text-center">
                <h1 class="display-inblock">&nbsp;</h1><br />
                <p class="display-inblock">&nbsp;</p>
                <div class="row text-left">
                    <div class="col-xs-12 col-md-8 col-md-offset-2">
                        
                        <form action="<?php echo Yii::app()->createUrl('/site/search'); ?>" method="GET" id="home-search-form">
                            <label for="home-search-input" class="hidden-xs"><?= Yii::t('app', 'Location') ?></label><input type="text" name="l" id="home-search-input" placeholder="<?= Yii::t('app', 'Paris, France') ?>" autocomplete="off"><a href="#" class="btn-submit"><i class="fa fa-map-o"></i></a>
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