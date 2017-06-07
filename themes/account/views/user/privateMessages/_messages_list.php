<p class="text-center text-muted lead"><?= Yii::t('app', 'New dialog started.'); ?></p>

<?php
    if (!empty($messages))
        foreach ($messages as $message) {
            $this->renderPartial('_message', array('data' => $message));
        }