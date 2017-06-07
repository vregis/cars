<?php
    $this->breadcrumbs=array(
        'Управление предложениями'=>array('/offers/default/admin'),
        $offer->title=>array('/offers/default/update', 'id'=>$offer->id),
        'Управление параметрами',
    );

    $this->pageTitle = 'Управление параметрами — '.Yii::app()->name;

    $this->title = 'Предложения';
?>


<div class="tabs-container">
    <?php echo $this->renderPartial('/default/_tabs', array('model'=>$offer)); ?>
    
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h3>Управление параметрами</h3>
                <br />
                <form action="" method="POST">
                    <?php 
                    if (!empty($parameters))
                        foreach ($parameters as $parameter) {
                        ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <?php 
                                        echo CHtml::label($parameter->name, 'parameter-'.$parameter->id, array('required' => $parameter->is_required)); 

                                        if ($parameter->type == 0)
                                            echo CHtml::dropDownList('parameter-'.$parameter->id,$parameter->getOfferValue($offer->id),$parameter->valuesData,array('class'=>'form-control', 'empty' => 'Не указано')); 
                                        elseif ($parameter->type == 1 || $parameter->type == 2)
                                            echo CHtml::textField('parameter-'.$parameter->id,$parameter->getOfferValue($offer->id),array('class'=>'form-control')); 
                                        elseif ($parameter->type == 3)
                                            echo '<div class="checkbox i-checks">'.CHtml::checkBox('parameter-'.$parameter->id,$parameter->getOfferValue($offer->id),array('class'=>'form-control','value'=>'1', 'uncheckValue'=>'0')).'</div>'; 
                                        elseif ($parameter->type == 4)
                                            echo CHtml::dropDownList('parameter-'.$parameter->id,explode(', ', $parameter->getOfferValue($offer->id)),$parameter->valuesData,array('class'=>'chosen-select', 'multiple' => true, 'style' => 'width: 100%;', 'data-placeholder' => 'Выберите несколько вариантов...')); 
                                    ?>
                                    <span class="help-block m-b-none text-danger"><?php if (!empty($errors[$parameter->id])) echo $errors[$parameter->id]; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    ?>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;&nbsp; Применить изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>