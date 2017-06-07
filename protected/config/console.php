<?php

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'GetUpWay Cron Jobs',

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
        'application.helpers.*',
        'ext.phaActiveColumn.*',
        'ext.YiiMailer.YiiMailer',
        'application.extensions.easyPaypal.*',
    ),

    'modules'=>array(
        'user'=>array(
            'tableUsers'=>'users',
            'tableProfiles'=>'profiles',
            'tableProfileFields'=>'profiles_fields',
        ),

        'siteVars'=>array(),

        'staticPages'=>array(),

        'articles'=>array(),

        'metaTags'=>array(),

        'offers'=>array(),

        'orders'=>array(),

        'parameters'=>array(),
    ),

    // application components
    'components'=>array(    
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron.log',
                    'levels'=>'error, warning',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron_trace.log',
                    'levels'=>'trace',
                ),
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
    ),

    'params'=>require(dirname(__FILE__).'/core_params.php'),
);