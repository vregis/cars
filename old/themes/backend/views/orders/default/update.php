<?php
/* @var $this OrdersController */
/* @var $model Orders */

    $this->breadcrumbs=array(
        'Управление заказами'=>array('admin'),
        'Редактирование заказа #'.$model->id,
    );

    $this->pageTitle = 'Редактирование заказа #'.$model->id.' — '.Yii::app()->name;

    $this->title = 'Управление заказами';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Редактирование заказа #<?php echo $model->id; ?></h5>
    </div>
    <div class="ibox-content">
        <?php echo $this->renderPartial('_form', array('model'=>$model, 'a_options'=>$a_options)); ?>
        
        <hr class="hr-line-dashed" />
        
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <h4>История изменений</h4>
                <p><?php 
                if (!empty($model->log))
                    echo nl2br($model->log); 
                else 
                    echo '<em class="text-muted">Нет информации.</em>';
                ?></p>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="pull-right">
                    <h4>Статус заказа</h4>
                    <form action="" method="POST" class="btn-group">
                    <?php 
                        if ($model->status == Orders::STATUS_NEW) $class[Orders::STATUS_NEW] = 'btn btn-primary'; else $class[Orders::STATUS_NEW] = 'btn btn-white';
                        if ($model->status == Orders::STATUS_APPROVED) $class[Orders::STATUS_APPROVED] = 'btn btn-primary'; else $class[Orders::STATUS_APPROVED] = 'btn btn-white';
                        if ($model->status == Orders::STATUS_PAID) $class[Orders::STATUS_PAID] = 'btn btn-primary'; else $class[Orders::STATUS_PAID] = 'btn btn-white';
                        if ($model->status == Orders::STATUS_SUCCESS) $class[Orders::STATUS_SUCCESS] = 'btn btn-primary'; else $class[Orders::STATUS_SUCCESS] = 'btn btn-white';
                        if ($model->status == Orders::STATUS_CANCELED) $class[Orders::STATUS_CANCELED] = 'btn btn-danger'; else $class[Orders::STATUS_CANCELED] = 'btn btn-warning';

                        echo CHtml::submitButton($model->statuses[Orders::STATUS_NEW], array('class' => $class[Orders::STATUS_NEW], 'name' => 'status'.Orders::STATUS_NEW));
                        echo CHtml::submitButton($model->statuses[Orders::STATUS_APPROVED], array('class' => $class[Orders::STATUS_APPROVED], 'name' => 'status'.Orders::STATUS_APPROVED));
                        echo CHtml::submitButton($model->statuses[Orders::STATUS_PAID], array('class' => $class[Orders::STATUS_PAID], 'name' => 'status'.Orders::STATUS_PAID));
                        echo CHtml::submitButton($model->statuses[Orders::STATUS_SUCCESS], array('class' => $class[Orders::STATUS_SUCCESS], 'name' => 'status'.Orders::STATUS_SUCCESS));
                        echo CHtml::submitButton($model->statuses[Orders::STATUS_CANCELED], array('class' => $class[Orders::STATUS_CANCELED], 'name' => 'status'.Orders::STATUS_CANCELED));
                    ?>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>