<?php $this->beginContent('//layouts/main'); ?>

    <!-- Account -->   
    <div class="container top-block">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-lg-9">
                <div class="im-content">

                    <?php echo $content; ?>
                    
                </div>                
            </div>
            <div class="col-xs-12 col-sm-4 col-lg-3 im-list">
                <h4>My Contacts</h4>
                
                <?php
                    $items = PrivateMessages::getMyContacts();
                
                    if (!empty($items))
                        $this->widget('zii.widgets.CMenu',array(
                            'encodeLabel'=>false,
                            'items'=>$items,
                        ));
                    else
                        echo '<p class="text-muted">No contacts found.</p>';
                ?>
            </div>
        </div>
    </div>

<?php $this->endContent();