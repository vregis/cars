<?php
    $label_name = Yii::t('parameters', $data->name);

    if ($data->type != 3) echo CHtml::label($label_name, 'parameter-'.$data->id, array('required' => $data->is_required)); 

    if ($data->type == 0)
        echo CHtml::dropDownList('parameter-'.$data->id,$data->getOfferValue($offer->id),$data->valuesData,array('class'=>'form-control', 'empty' => Yii::t('app', 'Не указано'))); 
    elseif ($data->type == 1 || $data->type == 2)
        echo CHtml::textField('parameter-'.$data->id,$data->getOfferValue($offer->id),array('class'=>'form-control')); 
    elseif ($data->type == 3) {
        echo '<div class="checkbox i-checks">'; 
        echo CHtml::checkBox('parameter-'.$data->id, $data->getOfferValue($offer->id), array('class'=>'form-control', 'value'=>'1', 'uncheckValue'=>'0'));
        echo CHtml::label($label_name, 'parameter-'.$data->id, array('required' => $data->is_required));
        echo '</div>'; 
    } elseif ($data->type == 4)
        echo CHtml::dropDownList('parameter-'.$data->id,explode(', ', $data->getOfferValue($offer->id)), $data->valuesData,array('class'=>'chosen-select', 'multiple' => true, 'style' => 'width: 100%;', 'data-placeholder' => Yii::t('app', 'Select several variants...'))); 
?>
<span class="help-block m-b-none text-danger"><?php if (!empty($errors[$data->id])) echo $errors[$data->id]; ?></span>