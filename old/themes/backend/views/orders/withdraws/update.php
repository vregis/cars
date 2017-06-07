<?php
/* @var $this WithdrawsController */
/* @var $model Withdraws */

    $this->breadcrumbs=array(
        'Управление заявками'=>array('admin'),
        'Редактирование заявки #'.$model->id,
    );

    $this->pageTitle = 'Редактирование заявки #'.$model->id.' — '.Yii::app()->name;

    $this->title = 'Заявки на вывод средств';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование заявки #<?php echo $model->id; ?></h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        <?php 
            if ($model->is_approved) {
                echo '<br /><br />';
                echo '<h4 class="text-primary">Документ подтвержден!</h4>';
                echo '<p>';
                echo 'Подтвердил: '.$model->approvedBy->profile->name.'<br />';
                echo 'Дата подтверждения: '.Yii::app()->locale->dateFormatter->format("d MMMM yyyy, в H:mm", $model->date_approved);
                echo '</p>';
            }
        ?>
        <hr />
        <p><?php echo $model->log; ?></p>
    </div>
</div>