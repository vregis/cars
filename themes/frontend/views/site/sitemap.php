<?php

    $this->pageTitle = 'Карта сайта — '.Yii::app()->name;

?>

<div class="page-top-promo">
    <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/img/sitemap-bg.jpg', '', array('class' => 'img-responsive')); ?>
    <div class="container">
        <h1>Карта сайта</h1>
    </div>
</div>

<div class="container">
    <p class="lead text-center"><br />Быстрая навигация по основным разделам сайта</p>
    
    <div class="row">
        <div class="col-sm-12">
            <ul>
                <li>Статические страницы
                    <ul>
                        <?php foreach($staticPages as $sp):?>
                            <li><a href = '/<?php echo $sp->url_name?>.html'><?php echo $sp->menu_name?></a></li>
                        <?php endforeach;?>
                    </ul>
                </li>
                <li>Статьи
                    <ul>
                        <?php foreach($articles as $article):?>
                            <li><a href = '/stories/<?php echo $article->url_name?>'><?php echo $article->title?></a></li>
                        <?php endforeach;?>
                    </ul>
                </li>
                <li>Категории
                    <ul>
                        <?php foreach($categories as $category):?>
                            <?php $offers = (new Offers())->getOffersFromCategoryId($category->id);?>
                            <?php if($offers):?>
                                <li><?php echo $category->name?>
                                    <ul>
                                        <?php foreach($offers as $offer):?>
                                            <li><a href="/s/~o<?php echo $offer->id?>"><?php echo $offer->title?></a></li>
                                        <?php endforeach;?>
                                    </ul>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
