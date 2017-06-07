<?php
        
    switch ($id) {
        case 'ground': $category = 'Ground'; break;
        case 'water': $category = 'Water'; break;
        case 'air': $category = 'Air'; break;
        default: $category = 'Ground'; break;
    }
    
    $this->breadcrumbs = array(
        Yii::t('app', 'Stories') => array('/articles/default/index'),
        $category
    );

    $this->pageTitle = 'Stories: '.$category.' | '.Yii::app()->name;

?>     

    <div class="container">
        <div class="row featured-stories">
            <div class="col-xs-12 col-sm-4">
                <?php
                if (!empty($articles)) 
                    foreach ($articles as $index => $article) {
                        if ($index % 3 == 0)
                            $this->renderPartial('_featured_view', array('data' => $article));
                    }
                ?>
            </div>
            <div class="col-xs-12 col-sm-4">
                <?php
                if (!empty($articles)) 
                    foreach ($articles as $index => $article) {
                        if ($index % 3 == 1)
                            $this->renderPartial('_featured_view', array('data' => $article));
                    }
                ?>
            </div>
            <div class="col-xs-12 col-sm-4">
                <?php
                if (!empty($articles)) 
                    foreach ($articles as $index => $article) {
                        if ($index % 3 == 2)
                            $this->renderPartial('_featured_view', array('data' => $article));
                    }
                ?>
            </div>
        </div>
    </div>
