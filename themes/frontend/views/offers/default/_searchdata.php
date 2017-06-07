<?php
if (!empty($items))
    foreach ($items as $item) {
        $this->renderPartial('/offers/default/_search', array('data' => $item));
    }
else {
    echo '<p class="text-muted">'.Yii::t('app', 'No offers found.').'</p>';
}