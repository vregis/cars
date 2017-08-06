    </div> 
    
    <!-- Footer -->
    <div class="container-fluid" id="footer">   
        <div id="subscription-footer">
            <div class="container">
                <form action="<?= Yii::app()->createUrl('/site/subscription') ?>" method="GET" id="footer-subscription" class="row">   
                    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4 col-lg-offset-1">
                        <h1><?= Yii::t('app', 'Receive Best Offers First') ?></h1>
                        <p><?= Yii::t('app', 'for your regions and interested categories') ?></p>
                    </div>    
                    <div class="col-xs-12 col-sm-3">
                        <input type="text" name="email" placeholder="<?= Yii::t('app', 'Enter Your E-mail...') ?>" class="white-placeholder">
                    </div>   
                    <div class="col-xs-12 col-sm-3 col-md-2">
                        <a href="#" class="btn btn-submit" data-target="footer-subscription"><i class="fa fa-check fa-before"></i> <?= Yii::t('app', 'Subscribe') ?></a>
                    </div>   
                </form>  
            </div>  
        </div>  
        <div id="submenu-footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-10 col-md-offset-1">
                        <?php
                            $menu = array(
                                array(
                                    'label' => Yii::t('app', 'About Subscription'),
                                    'url' => array('/site/subscription'),
                                ),
                                array(
                                    'label' => Yii::t('app', 'Unsubscribe'),
                                    'url' => array('/site/unsubscribe'),
                                ),
                                array(
                                    'label' => Yii::t('app', 'Feedback Information'),
                                    'url' => array('/site/feedback'),
                                ),
                                array(
                                    'label' => Yii::t('app', 'About Project'),
                                    'url' => array('/staticPages/default/view', 'url_name' => 'about'),
                                ),
                                array(
                                    'label' => Yii::t('app', 'Rights & Conditions'),
                                    'url' => array('/staticPages/default/view', 'url_name' => 'rights'),
                                ),
                            );

                            $this->widget('zii.widgets.CMenu',array(
                                'encodeLabel'=>false,
                                'lastItemCssClass'=>'last',
                                'items'=>$menu,
                            ));
                        ?> 
                    </div>    
                </div>    
            </div>  
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <?php
                        echo CHtml::link(CHtml::image(Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/img/footer-logo.png', Yii::app()->name, array('class'=>'img-responsive')), array('/site/index'));
                    
                        $menu = array(
                            array(
                                'label' => '<i class="fa fa-facebook"></i>',
                                'url' => SiteVars::v('SOCIAL_FB'),
                            ),
                            array(
                                'label' => '<i class="fa fa-twitter"></i>',
                                'url' => SiteVars::v('SOCIAL_TW'),
                            ),
                            array(
                                'label' => '<i class="fa fa-instagram"></i>',
                                'url' => SiteVars::v('SOCIAL_IN'),
                            ),
                        );

                        $this->widget('zii.widgets.CMenu',array(
                            'encodeLabel'=>false,
                            'htmlOptions'=>array('class' => 'footer-social'),
                            'items'=>$menu,
                        ));
                    ?> 
                </div>   
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <h4><?= Yii::t('app', 'My Profile') ?></h4>
                    <?php
                        if (Yii::app()->user->isGuest)
                            $menu = array(
                                array(
                                    'label' => Yii::t('app', 'Login'),
                                    'url' => array('/user/user/login'),
                                ),
                                array(
                                    'label' => Yii::t('app', 'Registration'),
                                    'url' => array('/user/user/registration'),
                                ),
                            );
                        else
                            $menu = array(
                                array(
                                    'label' => Yii::t('app', 'Go to Account'),
                                    'url' => array('/user/profile/stagePublic'),
                                ),
                                array(
                                    'label' => Yii::t('app', 'Change Password'),
                                    'url' => array('/user/profile/changepassword'),
                                ),
                                array(
                                    'label' => Yii::t('app', 'My Offers'),
                                    'url' => array('/offers/default/index'),
                                ),
                                array(
                                    'label' => Yii::t('app', 'My Orders'),
                                    'url' => array('/orders/default/index'),
                                ),
                                array(
                                    'label' => Yii::t('app', 'Logout'),
                                    'url' => array('/user/logout/logout'),
                                ),
                            );

                        $this->widget('zii.widgets.CMenu',array(
                            'encodeLabel'=>false,
                            'items'=>$menu,
                        ));
                    ?> 
                </div>       
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <h4><?= Yii::t('app', 'Information') ?></h4>
                    <?php
                        $menu = array(
                            array(
                                'label' => Yii::t('app', 'How it works?'),
                                'url' => array('/staticPages/default/view', 'url_name' => 'how-it-works'),
                            ),
                            array(
                                'label' => Yii::t('app', 'Subscription'),
                                'url' => array('/site/subscription'),
                            ),
                            array(
                                'label' => Yii::t('app', 'Payment Security'),
                                'url' => array('/staticPages/default/view', 'url_name' => 'payment-security'),
                            ),
                        );

                        $this->widget('zii.widgets.CMenu',array(
                            'encodeLabel'=>false,
                            'items'=>$menu,
                        ));
                    ?> 
                </div>    
                <div class="col-xs-12 col-md-3">
                    <p class="footer-payment-info"><?= Yii::t('app', 'We accept most popular payments') ?>:</p>
                    <ul class="footer-payment">
                        <li><?= CHtml::link(CHtml::image(Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/img/footer-visa.png', '', array('class' => 'img-responsive')), array('/')) ?></li>
                        <li><?= CHtml::link(CHtml::image(Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/img/footer-mastercard.png', '', array('class' => 'img-responsive')), array('/')) ?></li>
                        <li class="last"><?= CHtml::link(CHtml::image(Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/img/footer-paypal.png', '', array('class' => 'img-responsive')), array('/')) ?></li>
                    </ul>
                    <p class="footer-payment-security"><?= CHtml::link(Yii::t('app', 'Security issues'), array('/staticPages/default/view', 'url_name' => 'payment-security')) ?></p>
                </div>  
            </div>  
        </div> 
        <div id="footer-subs">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?= CHtml::link(Yii::t('app', 'Sitemap & Help'), array('/site/sitemap')) ?>
                    </div>  
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?= CHtml::link(Yii::t('app', 'Rights & Conditions of use'), array('/staticPages/default/view', 'url_name' => 'rights')) ?>
                    </div>  
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?= CHtml::link(Yii::t('app', 'Cookies Information'), array('/staticPages/default/view', 'url_name' => 'cookies')) ?>
                    </div>  
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <a href="http://www.kretivz.pro/" class="dev-link" target="_blank"><?= Yii::t('app', 'Создание сайта kretivz.pro</span>') ?></a>
                    </div>                    
                </div>  
            </div>  
        </div>  
    </div>
    
    <!-- Get Top Link -->
    <!-- <a href="#" id="get-top" class="manual-animation animated"><i class="fa fa-angle-up"></i></a> -->
    
    <?php if (!empty($this->popup)) $this->renderPartial('//popups/default/_view', array('data' => $this->popup)); ?>
    
    <?php if (Yii::app()->user->isGuest) $this->renderPartial('//user/user/_login_modal', array('model' => $this->loginModel)); ?>
    
    <?php
    if (!empty($this->breadcrumbs)) {
        echo '<script type="application/ld+json">';
        $data = array(
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(),
        );
        $i = 1;
        foreach ($this->breadcrumbs as $label => $url) {
            $data['itemListElement'][] = array(
                '@type' => 'ListItem',
                'position' => $i,
                'item' => array(
                    '@id' => CHtml::normalizeUrl($url),
                    'name' => $label
                ),
            );
            
            $i++;
        }
        echo json_encode($data);
        echo '</script>';
    }
    ?>
    
    <div id="header-dropdown-litter"></div>
    
    <?php if ($this->categoryDropdown !== false) echo $this->categoryDropdown; ?>
    
    <?php
        $counters_code = SiteVars::v('COUNTERS');
        if (!Yii::app()->user->isGuest) 
            $user_id = Yii::app()->user->id;        
        else
            $user_id = 'guest';            
        echo str_replace("ga('set', 'userId', {{USER_ID}});", "ga('set', 'userId', 'user-".Yii::app()->user->id."');", $counters_code);
    ?>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    
    <!-- JavaScript Files -->
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/bootstrap.min.js"></script>
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/icheck.min.js"></script>
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/daterangepicker/moment-with-locales.min.js"></script>
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/daterangepicker/jquery.daterangepicker.min.js"></script>
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/bootstrap-select/bootstrap-select.min.js"></script>
    
  <!--  <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/fancybox/jquery.fancybox.pack.js"></script>
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/fancybox/jquery.fancybox-thumbs.js"></script>
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/fancybox/jquery.fancybox-media.js"></script>
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/fancybox/jquery.fancybox-buttons.js"></script>-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.js"></script>

    <!-- Datepicker-->
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/plugins/datapicker/bootstrap-datepicker.js"></script>  
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/bootstrap-datetimepicker.min.js"></script>  

    <!-- Clock picker -->
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/plugins/clockpicker/clockpicker.js"></script>

    <!-- intlTelInput -->
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/plugins/intlTelInput/intlTelInput.min.js"></script>

    <!-- Toastr -->
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/plugins/toastr/toastr.min.js"></script>
    
    <!-- Chart.js -->
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/chart.js/Chart.bundle.min.js"></script>

    <!-- Select2-->
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/select2.full.min.js"></script>  
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/select2-ru.js"></script>  
    
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/catdd.js"></script>

    <!-- Listeners-->
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/listeners-date.js"></script>  
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/listeners-search.js"></script> 
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/listeners-popups.js"></script>  
    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/listeners.js"></script>
</body>
</html>