<?php
    $tab_menu = array(
        array(
            'label' => Yii::t('app', '1. Personal information'),
            'url' => array('/user/profile/stage1'),
        )
    );
    
    if ($this->userModel->first_complete > 0)
        $tab_menu[] = array(
            'label' => Yii::t('app', '2. Photos & Docs'),
            'url' => array('/user/profile/stage2'),
        );
    
    if ($this->userModel->first_complete > 1)
        $tab_menu[] = array(
            'label' => Yii::t('app', '3. My Phones'),
            'url' => array('/user/profile/stage3'),
        );
    
    if ($this->userModel->first_complete > 2)
        $tab_menu[] = array(
            'label' => Yii::t('app', '4. Profile Stats'),
            'url' => array('/user/profile/stage4'),
        );
    
    $tab_menu[] = array(
        'label' => Yii::t('app', 'Public view'),
        'url' => array('/user/profile/stagePublic'),
    );

    $this->widget('zii.widgets.CMenu',array(
        'encodeLabel'=>false,
        'items'=>$tab_menu,
        'htmlOptions' => array(
            'class' => 'nav nav-tabs small-tabs'
        ),
    ));  