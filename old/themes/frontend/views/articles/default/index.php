<?php
    
    $this->breadcrumbs = array(
        Yii::t('app', 'Stories')
    );

    $this->pageTitle = 'Stories';

?>     

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <?php
                if (!empty($articles_ground)) 
                    foreach ($articles_ground as $index => $article) {
                        $this->renderPartial('_view', array('data' => $article));
                    }
                ?>
            </div>
            <div class="col-xs-12 col-sm-4">
                <?php
                if (!empty($articles_water)) 
                    foreach ($articles_water as $index => $article) {
                        $this->renderPartial('_view', array('data' => $article));
                    }
                ?>
            </div>
            <div class="col-xs-12 col-sm-4">
                <?php
                if (!empty($articles_air)) 
                    foreach ($articles_air as $index => $article) {
                        $this->renderPartial('_view', array('data' => $article));
                    }
                ?>
            </div>
        </div>
    </div>
