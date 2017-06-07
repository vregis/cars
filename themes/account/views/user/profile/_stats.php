<?php
    $profile = $model->profile;
    $progress = $profile->profileProgress;
?>

<!--<div class="profile-stats">
    <h4>Actual Stats</h4>
    <div class="stat">
        <span class="stat-label"><strong>General information</strong> &mdash; 78% complete</span>
        <span class="stat-cover"><span class="stat-value" data-width="78"></span></span>
    </div>
    <div class="stat">
        <span class="stat-label"><strong>Photos & Docs</strong> &mdash; 21% complete</span>
        <span class="stat-cover"><span class="stat-value" data-width="21"></span></span>
    </div>
    <div class="stat">
        <span class="stat-label"><strong>Phone Approved</strong> &mdash; 56% complete</span>
        <span class="stat-cover"><span class="stat-value" data-width="56"></span></span>
    </div>
    <div class="total-stats">
        Total complete &mdash;
        <span class="total-value">97%</span>
    </div>
</div>-->

<h4 class="text-center" style="margin-bottom: -20px;">Profile Progress</h4>

<?= CHtml::tag('canvas', array(
    'id' => 'myChart',
    'width' => '100%',
    'data-personal-info' => $progress['Personal Info'],
    'data-social' => $progress['Social'],
    'data-photos' => $progress['Photos'],
    'data-documents' => $progress['Documents'],
    'data-phones' => $progress['Phones'],
    'data-account' => $progress['Account'],
), '', true) ?>

<p class="text-thin text-center">Total complete &mdash; <span class="total-value"><?= $progress['Total'] ?>%</span></p>