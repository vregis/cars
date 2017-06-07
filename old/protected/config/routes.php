<?php

return array(
    '<language:(ru|de|es)>/'=>'site/index',
    '/'=>'site/index',

    //Profiles
    '<language:(ru|de|es)>/u/<id:\d+>'=>'user/profile/view',
    'u/<id:\d+>'=>'user/profile/view',

    //User profile
    '<language:(ru|de|es)>/my'=>'user/profile/edit',
    '<language:(ru|de|es)>/my/stage-1'=>'user/profile/stage1',
    '<language:(ru|de|es)>/my/stage-2'=>'user/profile/stage2',
    '<language:(ru|de|es)>/my/stage-3'=>'user/profile/stage3',
    '<language:(ru|de|es)>/my/stage-4'=>'user/profile/stage4',
    '/my'=>'user/profile/edit',
    '/my/stage-1'=>'user/profile/stage1',
    '/my/stage-2'=>'user/profile/stage2',
    '/my/stage-3'=>'user/profile/stage3',
    '/my/stage-4'=>'user/profile/stage4',
    '/my/settings'=>'user/profile/settings',
    '/my/newpass'=>'user/profile/changepassword',  
    '/my/docs'=>'user/userDocuments/index',
    '/my/favourites'=>'user/userFavourites/index',
    
    '/my/orders'=>'/orders/default/index',
    '/my/orders/~o<id:\d+>'=>'/orders/default/view',
    '/my/orders/~e<id:\d+>'=>'/orders/default/edit',
    '/my/orders/~d<id:\d+>'=>'/orders/default/delete',
    '/my/orders/~e<id:\d+>/pay'=>'/orders/default/pay',
    '/my/orders/payments'=>'/orders/payments/index',
    
    '/my/offers'=>'/offers/default/index',
    '/my/offers/~e<id:\d+>'=>'/offers/default/edit',
    '/my/offers/~d<id:\d+>'=>'/offers/default/delete',
    '/my/offers/~e<id:\d+>/params'=>'/offers/offersParameterValues/index',
    
    '/my/offers/~e<id:\d+>/faq'=>'/offers/offerFaq/index',
    '/my/offers/~e<id:\d+>/faq/add'=>'/offers/offerFaq/add',
    '/my/offers/faq/~e<id:\d+>'=>'/offers/offerFaq/edit',
    
    '/my/offers/~e<id:\d+>/options'=>'/offers/offerOptions/index',
    '/my/offers/~e<id:\d+>/options/add'=>'/offers/offerOptions/add',
    '/my/offers/options/~e<id:\d+>'=>'/offers/offerOptions/edit',
    
    '/my/offers/~e<id:\d+>/photos'=>'/offers/offerPhotos/index',
    '/my/offers/~e<id:\d+>/faq/add'=>'/offers/offerPhotos/add',
    '/my/offers/faq/~e<id:\d+>'=>'/offers/offerPhotos/edit',
    
    '/my/offers/~e<id:\d+>/docs'=>'/offers/offerDocuments/index',
    '/my/offers/~e<id:\d+>/docs/add'=>'/offers/offerDocuments/add',
    '/my/offers/docs/~e<id:\d+>'=>'/offers/offerDocuments/edit',

    //Individual
    '<language:(ru|de|es)>/feedback'=>'site/feedback',
    'feedback'=>'site/feedback',
    '<language:(ru|de|es)>/subscription'=>'site/subscription',
    'subscription'=>'site/subscription',
    '<language:(ru|de|es)>/currencies'=>'site/currencies',
    'currencies'=>'site/currencies',
    '<language:(ru|de|es)>/lang'=>'site/languages',
    'lang'=>'site/languages',

    'sitemap'=>'site/sitemap',
    'sitemap.xml'=>'site/sitemapxml',

    //News, Articles
    'stories'=>'articles/default/index',
    'stories/featured-<id>'=>'articles/default/featured',
    'stories/page-<page:\d+>'=>'articles/default/index',
    'stories/<url_name:[a-zA-Z0-9-_]+>'=>'articles/default/view',

    //Private messages
    'im'=>'user/privateMessages/index',
    '<language:(ru|de|es)>/im'=>'user/privateMessages/index',
    'im~<id:\d+>'=>'user/privateMessages/dialog',
    '<language:(ru|de|es)>/im~<id:\d+>'=>'user/privateMessages/dialog',

    //Offers
    '<language:(ru|de|es)>/s'=>'/site/search',
    's'=>'/site/search',
    '<language:(ru|de|es)>/s/p<page:\d+>'=>'/site/search',
    's/p<page:\d+>'=>'/site/search',
    '<language:(ru|de|es)>/s/~o<id:\d+>'=>'offers/default/view',
    's/~o<id:\d+>'=>'offers/default/view',
    '<language:(ru|de|es)>/s/~o<id:\d+>/order'=>'offers/default/order',
    's/~o<id:\d+>/order'=>'/offers/default/order',

    //Static pages
    '<language:(ru|de|es)>/<url_name:[a-zA-Z0-9-_]+>.html'=>'staticPages/default/view',
    '/<url_name:[a-zA-Z0-9-_]+>.html'=>'staticPages/default/view',

    //Auth
    'hello'=>'/user/login/login',
    'socialLogin'=>'/site/socialLogin',
    'goodbye'=>'/user/logout/logout',
    'welcome'=>'/user/registration/registration',
    'recover-pass'=>'/user/recovery/recovery',
    'active/<email>/<activkey>'=>'/user/activation/activation',

    'imageUpload'=>'site/imageUpload',
    'fileUpload'=>'site/fileUpload',

    //admin
    'admin/'=>'site/admin',
    'admin/<controller:\w+>/create'=>'<controller>/create',
    'admin/<controller:\w+>/<id:\d+>/update'=>'<controller>/update',
    'admin/<controller:\w+>/delete/<id:\d+>'=>'<controller>/delete',
    'admin/<controller:\w+>'=>'<controller>/admin',

    //general actions
    '<controller:\w+>/<id:\d+>'=>'<controller>/view',

    //Basic
    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
    '<controller:\w+>/page_<page:\d+>'=>'<controller>/index',
    '<controller:\w+>'=>'<controller>/index',
);