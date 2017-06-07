<div class="col-xs-12 col-sm-6 col-md-4 <?= (($col == 1)?('col-md-offset-2'):('')) ?>">
<?php
    foreach ($parameters as $key => $parameter) {
        if ($key % 2 == $col) {
        ?>                    
            <div class="form-group">
                <?= $this->renderPartial('_view', array('data' => $parameter, 'offer' => $offer, 'errors' => $errors)) ?>
            </div>
        <?php
        }
    }
?>
</div>