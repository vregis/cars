<div class="dialog-container">
    <div class="dialog-shadow"></div> 

    <div id="dialog-box">
        <?php $this->renderPartial('_messages_list', array('messages' => $messages)) ?>
    </div>
    
    <?php $this->renderPartial('_form', array('model' => $model)) ?>

</div>