<?php
    /* @var $this OfferAddressesController */
    /* @var $model OfferAddresses */

    $this->breadcrumbs=array(
        'Управление пользователями'=>array('/user/admin/admin'),
        $model->user->profile->name=>array('/user/admin/update', 'id'=>$model->user_id),
        'Управление адресами',
    );

    $this->pageTitle = 'Управление адресами — '.Yii::app()->name;

    $this->title = 'Пользователи';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/admin/_tabs', array('model'=>$model->user)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Управление адресами</h3>
                <br />
                <?php
                    echo '<p class="text-right">'.CHtml::link('+ Добавить адрес', array('create', 'id'=>$model->user_id), array('class'=>'btn btn-primary text-right')).'</p>';
            
                    $this->renderPartial('admingrid', array('model'=>$model));
                ?>
            </div>
        </div>
    </div>
</div>