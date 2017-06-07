<?php
    $this->breadcrumbs=array(
        'Управление параметрами'=>array('/parameters/default/admin'),
        'Редактирование параметра «'.$model->parameter->name.'»'=>array('/parameters/default/update', 'id'=>$model->parameter_id),
        'Доступные значения',
    );

    $this->pageTitle = 'Доступные значения — '.Yii::app()->name;

    $this->title = 'Параметры';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Доступные значения</h5>
        
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="close-link">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
        <br />
        <?php             
            $this->renderPartial('_form', array('model'=>$form_model));
            echo '<br />';        
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>