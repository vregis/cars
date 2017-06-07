<?php
/* @var $this UserDocumentsController */
/* @var $model UserDocuments */

    $this->breadcrumbs=array(
        'Управление пользователями'=>array('/user/admin/admin'),
        $model->user->profile->name=>array('/user/admin/update', 'id'=>$model->user_id),
        'Управление документами'=>array('/user/userDocuments/admin', 'id'=>$model->user_id),
        'Редактирование документа #'.$model->id,
    );

    $this->pageTitle = 'Редактирование документа #'.$model->id.' — '.Yii::app()->name;

    $this->title = 'Пользователи';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/admin/_tabs', array('model'=>$model->user)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <?php 
                    if (!$model->is_approved) {
                        echo '<form action="" method="POST">';
                        echo '<button class="btn pull-right btn-warning" type="submit" name="approveDoc"><i class="fa fa-check"></i>&nbsp;&nbsp;Подтвердить документ</button>';
                        echo '</form>';
                    }
                ?>
                <h3>Документ «<?php echo $model->title; ?>»</h3>
                <br />
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
            </div>
        </div>
    </div>
</div>