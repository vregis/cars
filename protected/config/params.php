<?php

$core_params = require(dirname(__FILE__).'/core_params.php');

$core_params = array_merge($core_params, array(
    'redactor_options'=>array(
        'lang' => 'en',    
        'imageManagerJson' => 'http://'.$_SERVER['SERVER_NAME'].'/site/imageGetJson',    
        'imageUpload' => 'http://'.$_SERVER['SERVER_NAME'].'/site/imageUpload',
        'fileUpload' => 'http://'.$_SERVER['SERVER_NAME'].'/site/fileUpload',
        'fileManagerJson' => 'http://'.$_SERVER['SERVER_NAME'].'/resources/files/list.json',
        'minHeight' => 250,
        'autoresize' => false,
        'replaceDivs' => false,
        'linkEmail' => true,
        'linkAnchor' => true,
        'buttonSource' => true,
        'definedLinks' => 'http://'.$_SERVER['SERVER_NAME'].'/site/getJSONSitemap',
        'buttons' => array('html', 'formatting', 'bold', 'italic', 'underline', 'deleted', 'unorderedlist', 'orderedlist', 'outdent', 'indent', 'image', 'file', 'link', 'alignment', 'horizontalrule')
    ),
    
    'redactor_plugins'=>array(
        'video' => array(
            'js' => array('video.js',),
        ),
        'imagemanager' => array(
            'js' => array('imagemanager.js',),
        ),
        'filemanager' => array(
            'js' => array('filemanager.js',),
        ),
        'fullscreen' => array(
            'js' => array('fullscreen.js',),
        ),
        'clips' => array(
            'css' => array('clips.css',),
            'js' => array('clips.js',),
        ),
        'table' => array(
            'js' => array('table.js',),                
        ),
        'definedlinks' => array(
            'js' => array('definedlinks.js',),                
        ),
    ),

    'public_redactor_options'=>array(
        'lang' => 'en',  
        'minHeight' => 250,
        'autoresize' => false,
        'replaceDivs' => false,
        'linkEmail' => true,
        'linkAnchor' => true,
        'buttons' => array('bold', 'italic', 'underline', 'deleted', 'unorderedlist', 'orderedlist', 'outdent', 'indent', 'link', 'alignment', 'horizontalrule')
    ),
    
    'public_redactor_plugins'=>array()
));

return $core_params;