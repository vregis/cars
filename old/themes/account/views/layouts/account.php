<?php $this->beginContent('//layouts/main'); ?>

    <?php
    
    $menu = array(
        'My Orders' => array(
            array(
                'label' => '<i class="fa fa-calendar-check-o fa-fw"></i> '.Yii::t('app', 'Ordered Offers'),
                'url' => array('/orders/default/index', 't' => Orders::STATUS_APPROVED),
                'active' => (
                    !empty(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'orders' && 
                    Yii::app()->controller->id == 'default' && Yii::app()->controller->action->id == 'index'
                ),
            ),
            array(
                'label' => '<i class="fa fa-archive fa-fw"></i> '.Yii::t('app', 'Archived Orders'),
                'url' => array('/orders/default/archived'),
                'active' => (
                    !empty(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'orders' && 
                    Yii::app()->controller->id == 'default' && Yii::app()->controller->action->id == 'archived'
                ),
            ),
        ),
        'My Reviews' => array(
            array(
                'label' => '<i class="fa fa-commenting-o fa-fw"></i> '.Yii::t('app', 'Pending reviews'),
                'url' => array('/offers/offerReviews/index'),
                'active' => (
                    !empty(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'offers' && 
                    Yii::app()->controller->id == 'offerReviews' && Yii::app()->controller->action->id == 'index'
                ),
            ),
            array(
                'label' => '<i class="fa fa-comments-o fa-fw"></i> '.Yii::t('app', 'Submitted reviews'),
                'url' => array('/offers/offerReviews/archived'),
                'active' => (
                    !empty(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'offers' && 
                    Yii::app()->controller->id == 'offerReviews' && Yii::app()->controller->action->id == 'archived'
                ),
            ),
        ),
        'My Payments' => array(
            array(
                'label' => '<i class="fa fa-credit-card fa-fw"></i> '.Yii::t('app', 'Income Payments'),
                'url' => array('/orders/payments/income'),
                'active' => (Yii::app()->controller->id == 'payments' && Yii::app()->controller->action->id == 'income'),
            ),
            array(
                'label' => '<i class="fa fa-credit-card fa-fw"></i> '.Yii::t('app', 'Outcome Payments'),
                'url' => array('/orders/payments/outcome'),
                'active' => (Yii::app()->controller->id == 'payments' && Yii::app()->controller->action->id == 'outcome'),
            ),
        ),
        'My Offers' => array(
            array(
                'label' => '<i class="fa fa-bicycle fa-fw"></i> '.Yii::t('app', 'Active Offers'),
                'url' => array('/offers/default/index'),
                'active' => (
                    !empty(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'offers' && 
                    Yii::app()->controller->id == 'default' && Yii::app()->controller->action->id == 'index'
                ),
            ),
            array(
                'label' => '<i class="fa fa-lock fa-fw"></i> '.Yii::t('app', 'Archive'),
                'url' => array('/offers/default/archived'),
                'active' => (
                    !empty(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'offers' && 
                    Yii::app()->controller->id == 'default' && Yii::app()->controller->action->id == 'archived'
                ),
            ),
            array(
                'label' => '<i class="fa fa-calendar fa-fw"></i> '.Yii::t('app', 'Orders Schedule'),
                'url' => array('/orders/offered/index'),
                'active' => (
                    !empty(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'orders' && 
                    Yii::app()->controller->id == 'offered'
                ),
            ),
            array(
                'label' => '<i class="fa fa-map-o fa-fw"></i> '.Yii::t('app', 'My Addresses'),
                'url' => array('/user/userAddresses/index'),
                'active' => (Yii::app()->controller->id == 'userAddresses'),
            ),
        ),
        'My Profile' => array(
            array(
                'label' => '<i class="fa fa-user fa-fw"></i> '.Yii::t('app', 'Profile'),
                'url' => array('/user/profile/stagePublic'),
                'active' => (Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id != 'settings'),
            ),
            array(
                'label' => '<i class="fa fa-star-o fa-fw"></i> '.Yii::t('app', 'My Favourites'),
                'url' => array('/user/userFavourites/index'),
            ),
            array(
                'label' => '<i class="fa fa-file-text-o fa-fw"></i> '.Yii::t('app', 'Approval Documents'),
                'url' => array('/user/userDocuments/index'),
                'active' => (Yii::app()->controller->id == 'userDocuments'),
                'itemOptions' => array('class' => 'separated'),
            ),
            array(
                'label' => '<i class="fa fa-gears fa-fw"></i> '.Yii::t('app', 'Account Settings'),
                'url' => array('/user/profile/settings'),
                'active' => (Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'settings'),
            ),
        ),
    );
    
    ?>

    <!-- Account -->   
    <div class="container top-block">
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-lg-2 account-menu">                
                <?php
                
                    foreach ($menu as $header => $items) {
                        echo '<h5>'.Yii::t('app', $header).'</h5>';
                        
                        $this->widget('zii.widgets.CMenu',array(
                            'encodeLabel'=>false,
                            'items'=>$items,
                        ));
                    }
                ?>
            </div>
            <div class="col-xs-12 col-sm-9 col-lg-10">

                <?php echo $content; ?>
                
            </div>
        </div>
    </div>

<?php $this->endContent();