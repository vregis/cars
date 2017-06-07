<?php
    $this->pageTitle = UserModule::t("Login").' — '.Yii::app()->name;

    $this->breadcrumbs=array(
        UserModule::t("Login"),
    );
?>

    <div class="container text-center">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <h2><?php echo $title; ?></h2><br /><br />
                
                <p class="text-success text-center">
                    <big>
                        <?php echo $content; ?>
                    </big>
                </p>
            </div>
        </div>
    </div>
