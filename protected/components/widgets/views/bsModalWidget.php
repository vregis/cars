<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $header; ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $body; ?></p>
            </div>
            <?php if (!empty($footer)) { ?>
                <div class="modal-footer">
                    <?php echo $footer; ?>
                </div>
            <?php } ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->