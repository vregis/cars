<?php

$lang_menu = array(
    array(
        'label'=>'FR',
        'url'=>$this->getOwner()->createMultilanguageReturnUrl('fr'),
        'active'=>($currentLang == 'fr'),
    ),
    array(
        'label'=>'EN',
        'url'=>$this->getOwner()->createMultilanguageReturnUrl('en'),
        'active'=>($currentLang == 'en'),
    ),
); 

$this->widget('zii.widgets.CMenu',array(
    'encodeLabel'=>false,
    'id'=>'lang_menu',
    'items'=>$lang_menu,
));

?>