<?php 

    //User info
    $user = User::model()->findByPk(Yii::app()->user->id);  
    if (!empty($user->profile->photo))
        $user_photo = Yii::app()->request->hostInfo.'/resources/users/48_'.$user->profile->photo;
    else
        $user_photo = Yii::app()->theme->baseUrl.'/img/profile_small.jpg';     

?>

<ul class="nav" id="side-menu">
    <li class="nav-header">
        <div class="dropdown profile-element">
            <span><?php echo CHtml::image($user_photo, $user->profile->getName(), array('width'=>'48', 'height'=>'48', 'class'=>'img-circle')); ?></span>

            <a href="<?php echo Yii::app()->createUrl('/user/admin/update', array('id'=>$user->id)); ?>">
                <span class="clear">
                    <span class="block m-t-xs"><strong class="font-bold"><?php echo $user->profile->getName(); ?></strong></span>
                    <span class="text-muted text-xs block"><?php echo User::itemAlias('AdminStatus', $user->superuser); ?></span> 
                </span>
            </a>
        </div>
        <div class="logo-element">
            MyRentClub
        </div>
    </li>
    
    <li class="<?php if (!empty(Yii::app()->controller->module) && (Yii::app()->controller->module->id == 'offers')) echo 'active'; ?>">
        <?php
            echo CHtml::link('<i class="fa fa-fw fa-star-o"></i> <span class="nav-label">Предложения</span>', array('/offers/default/admin'));
        ?>
    </li>
    
    <li class="<?php if (!empty(Yii::app()->controller->module) && (Yii::app()->controller->module->id == 'orders')) echo 'active'; ?>">
        <?php
            echo CHtml::link('<i class="fa fa-fw fa-credit-card"></i> <span class="nav-label">Финансы</span> <span class="fa arrow"></span>', array('/orders/default/admin'));
        ?>
        <ul class="nav nav-second-level">
            <li class="<?php if (in_array(Yii::app()->controller->id, array('orders', 'orderedOptions'))) echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-arrow-right"></i> <span class="nav-label">Заказы</span>', array('/orders/default/admin'));
                ?>
            </li>
            <li class="<?php if (Yii::app()->controller->id == 'payments') echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-exchange"></i> <span class="nav-label">Платежи</span>', array('/orders/payments/admin'));
                ?>
            </li>
            <li class="<?php if (Yii::app()->controller->id == 'withdraws') echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-arrow-left"></i> <span class="nav-label">Заявки на вывод</span>', array('/orders/withdraws/admin'));
                ?>
            </li>
        </ul>
    </li>
    
    <li class="<?php if (
            !empty(Yii::app()->controller->module) && (Yii::app()->controller->module->id == 'parameters') ||
            in_array(Yii::app()->controller->id, array('categories', 'preoptions', 'parametersCategories', 'currencies', 'listLanguages', 'listCountries', 'listProvinces', 'places', 'listOfferTypes', 'paymentTypes'))
        ) echo 'active'; ?>">
        <?php
            echo CHtml::link('<i class="fa fa-fw fa-book"></i> <span class="nav-label">Справочники</span> <span class="fa arrow"></span>', array('/categories/admin'));
        ?>
        <ul class="nav nav-second-level">
            <li class="<?php if (Yii::app()->controller->id == 'categories' || Yii::app()->controller->id == 'parametersCategories' || Yii::app()->controller->id == 'preoptions') echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-folder-open-o"></i> <span class="nav-label">Категории</span>', array('/categories/admin'));
                ?>
            </li>
            <li class="<?php if (!empty(Yii::app()->controller->module) && (Yii::app()->controller->module->id == 'parameters') && (Yii::app()->controller->id == 'parameterGroups')) echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-toggle-right"></i> <span class="nav-label">Группы пар-ов</span>', array('/parameters/parameterGroups/admin'));
                ?>
            </li>
            <li class="<?php if (!empty(Yii::app()->controller->module) && (Yii::app()->controller->module->id == 'parameters') && (Yii::app()->controller->id != 'parameterGroups')) echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-sliders"></i> <span class="nav-label">Параметры</span>', array('/parameters/default/admin'));
                ?>
            </li>
            <li class="<?php if (Yii::app()->controller->id == 'currencies') echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-bitcoin"></i> <span class="nav-label">Валюты</span>', array('/currencies/admin'));
                ?>
            </li>
            <li class="<?php if (in_array(Yii::app()->controller->id, array('listCountries', 'listProvinces'))) echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-map-o"></i> <span class="nav-label">Страны</span>', array('/listCountries/admin'));
                ?>
            </li>
            <li class="<?php if (Yii::app()->controller->id == 'listLanguages') echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-language"></i> <span class="nav-label">Языки</span>', array('/listLanguages/admin'));
                ?>
            </li>
            <li class="<?php if (Yii::app()->controller->id == 'places') echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-map-marker"></i> <span class="nav-label">POI</span>', array('/places/admin'));
                ?>
            </li><!--
            <li class="<?php if (Yii::app()->controller->id == 'listOfferTypes') echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-star-o"></i> <span class="nav-label">Типы предложений</span>', array('/listOfferTypes/admin'));
                ?>
            </li>-->
            <li class="<?php if (Yii::app()->controller->id == 'paymentTypes') echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-paypal"></i> <span class="nav-label">Виды оплаты</span>', array('/paymentTypes/admin'));
                ?>
            </li>
        </ul>
    </li>

    <li class="<?php if (!empty(Yii::app()->controller->module->id) && Yii::app()->controller->module->id == 'user' || Yii::app()->controller->id == 'userDocuments' || Yii::app()->controller->id == 'userFavourites' || Yii::app()->controller->id == 'userReviews' || Yii::app()->controller->id == 'userReviewsPhotos' || Yii::app()->controller->id == 'privateMessages') echo 'active'; ?>">
        <?php
            echo CHtml::link('<i class="fa fa-fw fa-users"></i> <span class="nav-label">Пользователи</span>', array('/user/admin'));
        ?>
    </li>

    <li class="<?php if (Yii::app()->controller->id == 'subscribers') echo 'active'; ?>">
        <?php
            echo CHtml::link('<i class="fa fa-fw fa-envelope-o"></i> <span class="nav-label">Подписчики</span>', array('/subscribers/admin'));
        ?>
    </li>
    
    <li class="<?php if (
            !empty(Yii::app()->controller->module) && (
                Yii::app()->controller->module->id == 'articles' ||
                Yii::app()->controller->module->id == 'staticPages' ||
                Yii::app()->controller->module->id == 'metaTags' ||
                Yii::app()->controller->module->id == 'popups'
            )
        ) echo 'active'; ?>">
        <?php
            echo CHtml::link('<i class="fa fa-fw fa-file-text-o"></i> <span class="nav-label">Материалы сайта</span> <span class="fa arrow"></span>', array('/staticPages/default/admin'));
        ?>
        <ul class="nav nav-second-level">
            <li class="<?php if (!empty(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'staticPages') echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-file-text-o"></i> <span class="nav-label">Инфо-страницы</span>', array('/staticPages/default/admin'));
                ?>
            </li>
            <li class="<?php if (!empty(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'articles') echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-file-word-o"></i> <span class="nav-label">Статьи</span>', array('/articles/default/admin'));
                ?>
            </li>    
            <li class="<?php if (!empty(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'popups') echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-external-link"></i> <span class="nav-label">Всплыв. окна</span>', array('/popups/default/admin'));
                ?>
            </li>
            <li class="<?php if (!empty(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'metaTags') echo 'active'; ?>">
                <?php
                    echo CHtml::link('<i class="fa fa-fw fa-code"></i> <span class="nav-label">Мета-данные</span>', array('/metaTags/default/admin'));
                ?>
            </li>
        </ul>
    </li>
    <li class="<?php if (Yii::app()->controller->id == 'siteVars') echo 'active'; ?>">
        <?php
            echo CHtml::link('<i class="fa fa-fw fa-sliders"></i> <span class="nav-label">Настройки</span>', array('/siteVars/siteVars/admin'));
        ?>
    </li>
    <li class="special_link">
        <?php echo CHtml::link('<i class="fa fa-fw fa-laptop"></i> <span class="nav-label">Вернуться на сайт</span>', array('//site/index')); ?>
    </li>
</ul>