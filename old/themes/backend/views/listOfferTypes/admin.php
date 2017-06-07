<?php
    /* @var $this ListOfferTypesController */
    /* @var $model ListOfferTypes */

    $this->breadcrumbs=array(
        'Управление типами предложений',
    );

    $this->pageTitle = 'Управление типами предложений — '.Yii::app()->name;

    $this->title = 'Управление типами предложений';
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Управление типами предложений</h5>
        
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
        <?php
            echo '<p class="text-right">'.CHtml::link('+ Добавить', array('create'), array('class'=>'btn btn-primary text-right')).'</p>';
            
            $this->renderPartial('admingrid', array('model'=>$model));
        ?>
    </div>
</div>