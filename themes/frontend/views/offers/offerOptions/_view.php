<?php
/* @var $this OfferOptionsController */
/* @var $data OfferOptions */

    if (!empty($data->price_daily))
        $price = $data->price_daily;
    elseif (!empty($data->price_hourly))
        $price = $data->price_hourly;
    else
        $price = 0;
?>

    <div class="col-xs-12 col-md-6">
        <input type="radio" name="opt" value="<?= $data->id ?>" id="opt<?= $data->id ?>"  data-price="<?= $price ?>" data-alter-price="<?= $this->alterPrice($price) ?>" class="icheck calcOptions" use-paypal="<?= empty($use_paypal)?'0':'1'; ?>" <?= $key=='0'?'checked':''; ?> > <label for="opt<?= $data->id ?>"><?= $data->title; ?> <?= $this->formatPrice($price, '+ '); ?></label>
        <p><?= $data->description; ?></p>
    </div>