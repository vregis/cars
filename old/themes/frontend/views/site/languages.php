<?php     
    $this->pageTitle = Yii::t('app', 'Select language').' | '.Yii::app()->name;
    
    $this->breadcrumbs = array(
        Yii::t('app', 'Select language')
    );
?>

        <div class="container">
            <h3><?= Yii::t('app', 'Select language') ?></h3>
            <br />
            
            <div class="row languages-list">
                <div class="col-xs-12 col-sm-4">
                <?php 
                if (!empty($languages)) {
                    $i = 0;
                    foreach ($languages as $code => $language) {
                        $position = $i / count($languages);
                        
                        if ($position < 0.33)
                            $this->renderPartial ('_langchange', array('name' => $language, 'code' => $code));
                        
                        $i++;
                    }
                }
                ?>                    
                </div>
                
                <div class="col-xs-12 col-sm-4">
                <?php 
                if (!empty($languages)) {
                    $i = 0;
                    foreach ($languages as $code => $language) {
                        $position = $i / count($languages);
                        
                        if ($position >= 0.33 && $position < 0.67)
                            $this->renderPartial ('_langchange', array('name' => $language, 'code' => $code));
                        
                        $i++;
                    }
                }
                ?>                    
                </div>
                
                <div class="col-xs-12 col-sm-4">
                <?php 
                if (!empty($languages)) {
                    $i = 0;
                    foreach ($languages as $code => $language) {
                        $position = $i / count($languages);
                        
                        if ($position >= 0.67)
                            $this->renderPartial ('_langchange', array('name' => $language, 'code' => $code));
                        
                        $i++;
                    }
                }
                ?>                    
                </div>
            </div>
        </div>