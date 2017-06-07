<?php     
    $this->pageTitle = Yii::t('app', 'Change Currency').' | '.Yii::app()->name;
    
    $this->breadcrumbs = array(
        Yii::t('app', 'Change Currency')
    );
?>
  
        <div class="container">
            <h3><?= Yii::t('app', 'Change Currency') ?></h3>
            <br />
            
            <div class="row currencies-list">
                <div class="col-xs-12 col-sm-4">
                <?php 
                if (!empty($currencies))
                    foreach ($currencies as $key => $currency) {
                        $position = $key / count($currencies);
                        
                        if ($position < 0.33)
                            $this->renderPartial ('/currencies/_change', array('data' => $currency));
                    }
                ?>                    
                </div>
                
                <div class="col-xs-12 col-sm-4">
                <?php 
                if (!empty($currencies))
                    foreach ($currencies as $key => $currency) {
                        $position = $key / count($currencies);
                        
                        if ($position >= 0.33 && $position < 0.67)
                            $this->renderPartial ('/currencies/_change', array('data' => $currency));
                    }
                ?>                    
                </div>
                
                <div class="col-xs-12 col-sm-4">
                <?php 
                if (!empty($currencies))
                    foreach ($currencies as $key => $currency) {
                        $position = $key / count($currencies);
                        
                        if ($position >= 0.67)
                            $this->renderPartial ('/currencies/_change', array('data' => $currency));
                    }
                ?>                    
                </div>
            </div>
        </div>