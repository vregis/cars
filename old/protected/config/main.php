<?php

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'GetUpWay',
    'language'=>'en',
    'theme'=>'frontend',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.siteVars.models.*',
        'application.modules.siteVars.components.*',
        'application.modules.staticPages.models.*',
        'application.modules.staticPages.components.*',
        'application.modules.metaTags.models.*',
        'application.modules.metaTags.components.*',
        'application.modules.articles.models.*',
        'application.modules.articles.components.*',
        'application.modules.offers.models.*',
        'application.modules.offers.components.*',
        'application.modules.orders.models.*',
        'application.modules.orders.components.*',
        'application.modules.parameters.models.*',
        'application.modules.parameters.components.*',
        'application.modules.popups.models.*',
        'application.modules.popups.components.*',
        'application.helpers.*',
        'ext.phaActiveColumn.*',
        'ext.YiiMailer.YiiMailer',
        'ext.imperavi-redactor-widget-master.ImperaviRedactorWidget',
        'ext.EGMap.*',
        'ext.Facebook.*',
        'ext.Google.*',
        'ext.Google.Auth.*',
        'ext.Google.Cache.*',
        'ext.Google.Http.*',
        'ext.Google.IO.*',
        'ext.Google.Logger.*',
        'ext.Google.Service.*',
        'ext.Google.Signer.*',
        'ext.Google.Task.*',
        'ext.Google.Utils.*',
        'ext.Google.Verifier.*',
        'application.extensions.easyPaypal.*',
        'ext.ReCaptcha.ReCaptcha',
    ),

    'modules'=>array(
        // uncomment the following to enable the Gii tool

        /*'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'1234',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),*/

        'user'=>array(
            'tableUsers'=>'users',
            'tableProfiles'=>'profiles',
            'tableProfileFields'=>'profiles_fields',
            'sendActivationMail'=>true,
            'activeAfterRegister'=>false,
            'autoLogin'=>false,
            'captcha'=>array()
        ),

        'siteVars'=>array(),

        'staticPages'=>array(),

        'articles'=>array(),

        'metaTags'=>array(),

        'offers'=>array(),

        'orders'=>array(),

        'parameters'=>array(),

        'popups'=>array(),
    ),

    // application components
    'components'=>array(           
        'clientScript'=>array(
            'scriptMap'=>array(
                'jquery.js'=>false,
                'jquery-ui.min.js' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js',
                'jquery.ui.datepicker-ru.js' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/i18n/jquery.ui.datepicker-ru.js',
            ),
        ),
        
        'image'=>array(
            'class'=>'application.extensions.image.CImageComponent',
            'driver'=>'GD',
            'params'=>array('directory'=>'/resources'),
        ),
        
        'user'=>array(
            'class' => 'WebUser',
            'allowAutoLogin'=>true,
            'loginUrl' => array('/user/login/login'),
        ),
        
        'request'=>array(
            'enableCsrfValidation'=>false,
        ), 

        'urlManager'=>array(
            'class' => 'application.components.UrlManager',
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'rules'=>require(dirname(__FILE__).'/routes.php'),
        ),        
		
        'db'=>require(dirname(__FILE__).'/db.php'),

        /*'errorHandler'=>array(
            'errorAction'=>'site/error',
        ),*/
    ),

    'params'=>require(dirname(__FILE__).'/params.php'),
);