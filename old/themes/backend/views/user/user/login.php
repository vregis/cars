<?php
    $this->pageTitle = UserModule::t("Login").' — '.Yii::app()->name;

    $this->breadcrumbs=array(
        UserModule::t("Login"),
    );
?>

    <div class="middle-box text-center animated fadeInDown">
        <div>
            <h2>Панель управления Corvette</h2>
            <p class="text-muted">Доступ к защищенной части ограничен.</p><br />
            <h3>Пожалуйста, введите e-mail и пароль.</h3>
            <?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

                <p class="text-danger text-center">
                    <big>
                        <?php echo Yii::app()->user->getFlash('loginMessage'); ?><br />
                        <?php echo CHtml::errorSummary($model); ?>
                    </big>
                </p>

            <?php endif; ?>
            <?php echo CHtml::beginForm('', 'POST', array('class'=>'m-t', 'role'=>'form')); ?>                        
                <div class="form-group">
                    <?php echo CHtml::activeTextField($model,'username',array('class'=>'form-control', 'placeholder' => 'E-mail')); ?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::activePasswordField($model,'password',array('class'=>'form-control', 'placeholder' => 'Пароль')); ?>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Войти</button>
        
                <br />
                <h3>или войдите через социальные сети:</h3>
                <script src="//ulogin.ru/js/ulogin.js"></script>
                <div id="uLoginba296174" data-ulogin="display=small;fields=first_name,last_name,email,photo;verify=1;providers=facebook,twitter,google,vkontakte;hidden=yandex,livejournal,openid,odnoklassniki,mailru,lastfm,linkedin,liveid,soundcloud,steam,flickr,uid,youtube,webmoney,foursquare,tumblr,googleplus,dudu,vimeo,instagram,wargaming;redirect_uri=<?php echo Yii::app()->createAbsoluteUrl('/site/socialLogin'); ?>"></div>

                <br />
                <?php echo CHtml::link('Забыли пароль?', array('/user/recovery/recovery')); ?>
                
            <?php echo CHtml::endForm(); ?>
            <p class="m-t"> <small>Студия Виталия Комлева &copy; 2013 &ndash; <?php echo date('Y'); ?></small> </p>
        </div>
    </div>