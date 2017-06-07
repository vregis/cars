<div id="search-data">
<?php
$this->renderPartial('/offers/default/_searchdata', array('items' => $items));
?>
</div>

<?php if (!empty($items)) { ?>
<div id="search-pagination" data-page="<?= $pages->currentPage+1 ?>" data-max-page="<?= $pages->pageCount ?>">
    <div class="ajax-loader"><?= CHtml::image(Yii::app()->theme->baseUrl.'/img/ajax-loader.gif') ?></div>
    
    <div id="search-pagination-list">
    <?php
    $this->widget('application.components.widgets.feLinkPager', array(
        'pages' => $pages,
    ));
    ?>
    </div>
</div>
<?php } ?>
