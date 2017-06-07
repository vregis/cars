<?php if (Yii::app()->user->isGuest): ?>

<div id="uLogin" x-ulogin-params="display=buttons;fields=<?php echo $fields ?>;providers=<?php echo $providers ?>;hidden=<?php echo $hidden ?>;redirect_uri=<?php echo urlencode($redirect) ?>">
    <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/social_vk.png', 'VK', array('width'=>'32', 'height'=>'32', 'data-uloginbutton'=>'vkontakte')); ?>
    <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/social_ok.png', 'OK', array('width'=>'32', 'height'=>'32', 'data-uloginbutton'=>'odnoklassniki')); ?>
    <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/social_fb.png', 'FB', array('width'=>'32', 'height'=>'32', 'data-uloginbutton'=>'facebook')); ?>
    <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/social_tw.png', 'TW', array('width'=>'32', 'height'=>'32', 'data-uloginbutton'=>'twitter')); ?>
</div>

<?php endif ?>