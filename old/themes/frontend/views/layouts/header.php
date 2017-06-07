<!DOCTYPE html>
<html>
<head>

    <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/jquery-2.1.4.min.js"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow" />
    <title><?= CHtml::encode($this->pageTitle) ?></title>
    <!-- ////////////////////////////////// -->
    <!-- //      Start Stylesheets       // -->
    <!-- ////////////////////////////////// -->
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/select2.min.css">
	<link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/bootstrap-select/bootstrap-select.min.css">
    
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/fancybox/jquery.fancybox-thumbs.css">
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/fancybox/jquery.fancybox-buttons.css">
    
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/animate.css">
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/style.css">

    <!-- ClockPicker -->
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/plugins/clockpicker/clockpicker.css">

    <!-- Toastr style -->
    <link href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- intlTelInput style -->
    <link href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/plugins/intlTelInput/intlTelInput.css" rel="stylesheet">

    <!-- Datepicker -->
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/plugins/datapicker/datepicker3.css">
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/bootstrap-datetimepicker.min.css">

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/bootstrap-theme.min.css">
    <link href="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,700italic,700|Roboto+Condensed:400,300,300italic,400italic,700italic,700|Roboto+Slab:400,700,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <!--[if lt IE 9]>
        <script src="<?= Yii::app()->themeManager->getTheme('frontend')->baseUrl ?>/js/ie8-responsive-file-warning.js"></script>
    <![endif]-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <?= SiteVars::v('HEADER_LIKES') ?>    
   
</head>
<body data-language="<?= Yii::app()->language ?>">     
    <?= SiteVars::v('BODY_LIKES') ?>
        
    <div id="general-content">        
        <!-- Header -->
        <div id="header">
            <div class="container">
                <div class="row">                    
                    <div class="<?= ((Yii::app()->user->isGuest)?('col-xs-9 col-sm-5'):('col-xs-8 col-sm-4')) ?>">
                        <?= CHtml::link(CHtml::image(Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/img/logo.png', Yii::app()->name, array('class'=>'img-responsive')), array('/site/index')) ?>
                    </div>  
                    <div class="col-xs-12 hidden-xs col-sm-2 bordered-item">
                        <form action="<?= Yii::app()->createUrl('/site/siteSearch') ?>" method="GET">
                            <input type="text" name="s" placeholder="<?= Yii::t('app', 'Search...') ?>" class="white-placeholder">
                        </form>
                    </div>
                    <div class="col-xs-12 hidden-xs col-sm-2 bordered-item">
                        <?php 
                        if (Yii::app()->user->isGuest) {
                            echo CHtml::link(Yii::t('app', 'Login or Sign in').'&nbsp;&nbsp;&nbsp;<i class="fa fa-sign-in"></i>', array('/user/login/login'), array('class' => 'login-button'));
                        } else {
                        ?>
                        <a href="#" class="header-dropdown-link" data-target="user-menu"><i class="fa fa-user"></i>&nbsp;&nbsp;<?= $this->userModel->profile->firstname; ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down"></i></a>
                        <div class="header-dropdown" id="user-menu">
                            <?php
                                if (Yii::app()->user->isGuest)
                                    $menu = array(
                                        array(
                                            'label' => Yii::t('app', 'Login'),
                                            'url' => array('/user/login/login'),
                                        ),
                                        array(
                                            'label' => Yii::t('app', 'Registration'),
                                            'url' => array('/user/registration/registration'),
                                        ),
                                    );
                                else
                                    $menu = array(
                                        array(
                                            'label' => Yii::t('app', 'My Offers list'),
                                            'url' => array('/offers/default/index', 't' => Orders::STATUS_APPROVED),
                                        ),
                                        array(
                                            'label' => Yii::t('app', 'Orders History'),
                                            'url' => array('/orders/default/index'),
                                        ),
                                        array(
                                            'label' => Yii::t('app', 'My Payments'),
                                            'url' => array('/orders/payments/income'),
                                        ),
                                        array(
                                            'label' => Yii::t('app', 'My Profile'),
                                            'url' => array('/user/profile/stagePublic'),
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
                        <?php 
                        }
                        ?>
                    </div>
                    <?php
                    if (!Yii::app()->user->isGuest) {
                    ?>
                    <div class="col-xs-1 bordered-item">
                        <?php echo CHtml::link('<i class="fa fa-envelope"></i>'.((PrivateMessages::countNew())?('<span class="new-label pm-label-all animated flip">'.PrivateMessages::countNew().'</span>'):('')), array('/user/privateMessages/index')); ?>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="col-xs-12 hidden-xs col-sm-1 bordered-item">
                        <?php echo CHtml::link(CHtml::image(Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/img/flags/'.Yii::app()->language.'.png'), array('/site/languages'), array('class' => 'header-dropdown-link', 'data-target' => 'lang-menu')); ?>
                        <div class="header-dropdown" id="lang-menu">
                            <ul class="manual-styled">
                                <?php
                                if (!empty(Yii::app()->params['languages']))
                                    foreach (Yii::app()->params['languages'] as $code => $language) {
                                        $label = CHtml::image(Yii::app()->themeManager->getTheme('frontend')->baseUrl.'/img/flags/'.$code.'.png', $code).$language;
                                        if (Yii::app()->language != $code) {
                                            $params = $_GET;
                                            $params['language'] = $code;
                                            
                                            echo '<li>'.CHtml::link($label, array_merge(array($this->id.'/'.$this->action->id), $params)).'</li>';
                                        } else
                                            echo '<li>'.$label.'</li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 hidden-xs col-sm-1 bordered-item">
                        <?php echo CHtml::link(Yii::app()->params['currency']['name'], array('/site/currencies'), array('class' => 'header-dropdown-link', 'data-target' => 'currency-menu')); ?>
                        <div class="header-dropdown" id="currency-menu">
                            <ul class="manual-styled">
                                <?php
                                $currencies = Currencies::model()->findAll(array('order' => '`name` ASC'));
                                if (!empty($currencies))
                                    foreach ($currencies as $currency) {
                                        $label = $currency->name.'&nbsp;&nbsp;&nbsp;'.$currency->full_name;
                                        if (Yii::app()->params['currency']['id'] != $currency->id) {
                                            $params = $_GET;
                                            $params['cuch'] = $currency->id;
                                            
                                            echo '<li>'.CHtml::link($label, array_merge(array($this->id.'/'.$this->action->id), $params)).'</li>';
                                        } else
                                            echo '<li>'.$label.'</li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-1 bordered-item last">
                        <a href="#" class="header-dropdown-link" data-target="nav-menu"><i class="fa fa-bars"></i></a>
                        
                        <div class="header-dropdown" id="nav-menu">
                            <?php
                                $menu = array(
                                    array(
                                        'label' => Yii::t('app', 'About the Project'),
                                        'url' => array('/staticPages/default/view', 'url_name' => 'about'),
                                    ),
                                    array(
                                        'label' => Yii::t('app', 'How It Works?'),
                                        'url' => array('/staticPages/default/view', 'url_name' => 'how-it-works'),
                                    ),
                                    array(
                                        'label' => Yii::t('app', 'User Stories'),
                                        'url' => array('/articles/default/index'),
                                    ),
                                );

                                $this->widget('zii.widgets.CMenu',array(
                                    'encodeLabel'=>false,
                                    'items'=>$menu,
                                ));
                            ?> 
                            <hr />
                            <?php
                                $menu = array(
                                    array(
                                        'label' => Yii::t('app', 'Feedback'),
                                        'url' => array('/site/feedback'),
                                    ),
                                    array(
                                        'label' => Yii::t('app', 'Sitemap'),
                                        'url' => array('/site/sitemap'),
                                    ),
                                );

                                $this->widget('zii.widgets.CMenu',array(
                                    'encodeLabel'=>false,
                                    'items'=>$menu,
                                ));
                            ?> 
                        </div>
                    </div>
                </div>  
            </div>  
        </div>    
        
        <?php $this->widget('application.components.widgets.feBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
            'homeLink'=>CHtml::link('<i class="fa fa-home"></i>', array('/site/index')),
        )); ?>