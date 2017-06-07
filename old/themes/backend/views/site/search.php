<?php
$this->pageTitle = 'Поиск по сайту — '.Yii::app()->name;
$this->title = 'Поиск по сайту';

$this->breadcrumbs = array('Поиск по сайту');

Yii::app()->clientScript->registerMetaTag('', 'description');
?>   

<div class="ibox float-e-margins">
    <div class="ibox-content">
        <h2>
            <?php echo $this->plural($total, 'результат', 'результата', 'результатов'); ?> для: <span class="text-navy">«<?php echo $text; ?>»</span>
        </h2>
        <small>Запрос занял <?php echo $query_time; ?> сек.</small>
        
        <div class="search-form">
            <form action="<?php echo Yii::app()->createUrl('/site/adminSearch'); ?>" method="GET" id="search-form">
                <div class="input-group">
                    <input type="text" placeholder="Поиск по сайту..." name="text" value="<?php echo $_GET['text']; ?>" class="form-control input-lg">
                    <div class="input-group-btn">
                        <button class="btn btn-lg btn-primary btn-submit" data-target-id="search-form" type="submit">
                            Найти
                        </button>
                    </div>
                </div>

            </form>
        </div>
        
        <?php
            $arr = array(
                'accessories' => 'accessories', 
                'actions' => 'actions/default',
                'badges' => 'badges', 
                'banners' => 'banners/default', 
                'carDownloads' => 'carDownloads', 
                'carInfoBlocks' => 'carInfoBlocks', 
                'carModifications' => 'carModifications', 
                'cars' => 'cars', 
                'categories' => 'categories', 
                'galleries' => 'galleries', 
                'metaTags' => 'metaTags/default', 
                'news' => 'news/default', 
                'notifications' => 'notifications',
                'siteVars' => 'siteVars/siteVars',
                'sliderImages' => 'sliderImages/default',
                'staticPages' => 'staticPages/default',
                'stockCars' => 'stockCars',
                'videos' => 'videos',
            );
            foreach ($arr as $var_name => $controller) {
                $var_name_l = strtolower($var_name);
                
                if (empty($$var_name_l))
                    unset($arr[$var_name]);
            }
                        
            foreach ($arr as $var_name => $controller) {
                $var_name_l = strtolower($var_name);
                
                $view_path = '/'.$controller.'/_search';
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$$var_name_l,
                    'itemView'=>$view_path,
                    'summaryText'=>false,
                    'emptyText'=>false,
                    'template'=>'{items}',
                ));
            }
            
            $this->widget('application.components.widgets.beLinkPager', array(
                'pages' => $pages
            ));
        ?>

    </div>
</div>       