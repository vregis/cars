
<div class="search-block">
    <h5><?= CHtml::link($data->title, array('/staticPages/default/view', 'url_name'=>$data->url_name)); ?></h5>
    <p><?= mb_substr(strip_tags($data->text), 0, 150, 'UTF-8').'...' ?></p>
    <hr class="hr-line-dashed" />
</div>