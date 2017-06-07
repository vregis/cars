<?php
    $this->pageTitle = Yii::t('app', '4. Profile Stats').' | '.Yii::app()->name;

    $this->breadcrumbs=array(
        Yii::t('app', 'Profile Stats')
    );
    
    $progress = $profile->profileProgress;
?>


    <div class="account-content">
        <h3><?= Yii::t('app', 'Profile Information') ?></h3>
        <br />

        <?php $this->renderPartial('_tabs', array('model' => $model)) ?>
        <br />
                
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-1">

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
            </div>
            <div class="col-xs-12 col-sm-6 col-sm-offset-1 profile-tips">
                <h4>Improve your Profile</h4>
                <p>These tips will help you improve your profile and achieve more orders.</p>
                
                <?php
                if (!empty($progress['Improvements']))
                    foreach ($progress['Improvements'] as $chapter => $tips) {
                        echo '<h5>'.$chapter.' <sup class="text-muted">('.$progress[$chapter].'%)</sup></h5>';
                        echo '<ul>';
                        foreach ($tips as $tip) {
                            echo '<li><span class="text-success">[ + '.$tip[0].'%]</span> &mdash; '.$tip[1].'</li>';
                        }
                        echo '</ul>';
                    }
                ?>
            </div>
        </div>
    </div>