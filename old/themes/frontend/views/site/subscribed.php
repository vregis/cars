<?php    
    $this->pageTitle = Yii::t('app', 'Subscription').' | '.Yii::app()->name;
    
    $this->breadcrumbs = array(
        Yii::t('app', 'Subscription')
    );
?>

        <!-- Feedback -->   
        <div class="container">
            <div class="row info-block">
                <div class="col-xs-12">
                    <h2 class="text-center text-success"><?= Yii::t('app', 'Subscription Done!') ?></h2>
                    <br />
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12"> 
                    <?php 
                        echo '<p class="text-center text-danger lead">'.Yii::t('app', 'Thank you').', '.$model->name.'!</p>';
                    ?>
                    <p class="text-center"><?= Yii::t('app', 'We\'ll notify you about important news and updates of our service.') ?></p><br /><br />

                    <p class="text-center">
                        <br /><br />
                        <?php echo CHtml::link(Yii::t('app', 'Get Home').' <i class="fa fa-angle-right"></i>', array('/site/index'), array('class'=>'btn btn-primary'));?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo CHtml::link(Yii::t('app', 'My Account').' <i class="fa fa-angle-right"></i>', array('/user/profile/view'), array('class' => 'btn btn-default'));?>
                        <br /><br /><br />
                    </p>
                </div>
            </div>
        </div>    