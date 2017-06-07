<?php

class UWcheckBox {
	
	public $params = array(
		'modelName'=>'',
		'optionName'=>'',
		'emptyField'=>'',
                'value'=>'1', 
                'uncheckValue'=>'0',
		'relationName'=>'',
	);
	
	/**
	 * Widget initialization
	 * @return array
	 */
	public function init() {
		return array(
			'name'=>__CLASS__,
			'label'=>UserModule::t('CheckBox',array(),__CLASS__),
			'fieldType'=>array('INTEGER'),
			'params'=>$this->params,
			'paramsLabels' => array(
				'modelName'=>UserModule::t('Model Name',array(),__CLASS__),
				'optionName'=>UserModule::t('Lable field name',array(),__CLASS__),
				'emptyField'=>UserModule::t('Empty item name',array(),__CLASS__),
				'relationName'=>UserModule::t('Profile model relation name',array(),__CLASS__),
			),
		);
	}
	
	/**
	 * @param $value
	 * @param $model
	 * @param $field_varname
	 * @return string
	 */
	public function setAttributes($value,$model,$field_varname) {
		return $value;
	}
	
	/**
	 * @param $model - profile model
	 * @param $field - profile fields model item
	 * @return string
	 */
	public function viewAttribute($model,$field) {
		$file = $model->getAttribute($field->varname);
		if ($file == '0') {
			return 'No';
		} else
			return 'Yes';
		
	}
	
	/**
	 * @param $model - profile model
	 * @param $field - profile fields model item
	 * @param $params - htmlOptions
	 * @return string
	 */
	public function editAttribute($model,$field,$htmlOptions=array()) {
		if (!isset($params['options'])) $params['options'] = array();
		$options = $params['options'];
		unset($params['options']);
		
                $attributes = $model->attributeLabels();
		return '<br />'.CHtml::activeCheckBox($model,$field->varname,$params)
		.CHtml::activeLabelEx($model,$field->varname,array('label'=>$attributes[$field->varname],'style'=>'display:inline;'));
	}
	
}