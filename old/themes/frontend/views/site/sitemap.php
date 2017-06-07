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
    <br /><br /><br />
    
    <div class="row">
        <div class="col-xs-12 col-sm-3">
            <h5>111</h5>
            <br />
            <p><?php echo CHtml::link('Все модели', array('/cars/index'));?></p>
            <?php 
            if (!empty($cars))
                foreach ($cars as $car) {
                    echo '<p>'.CHtml::link($car->title, array('/cars/view', 'url_name' => $car->url_name)).'</p>';
                }
            ?>            
        </div>
        <div class="col-xs-12 col-sm-3">
            <h5>222</h5>
            <br />
            <p><?php echo CHtml::link('Подписка на новости', array('/site/subscription'));?></p>
        </div>
        <div class="col-xs-12 col-sm-3">
            <h5>333</h5>
            <br />
            <p><?php echo CHtml::link('Гарантия', array('/staticPages/default/view', 'url_name' => 'warranty'));?></p>
        </div>
        <div class="col-xs-12 col-sm-3">
            <h5>Контактная<br />информация</h5>
            <br />
            <p><?php echo CHtml::link('О компании', array('/staticPages/default/view', 'url_name' => 'about'));?></p>
            <p><?php echo CHtml::link('Обратная связь', array('/site/feedback'));?></p><br />
        </div>
    </div>
</div>
