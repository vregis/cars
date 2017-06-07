<?php
class feFileField extends CWidget
{
    
	public $model;    
	public $attribute;    
	public $value;
    
	public $delete_filename;
    
	public $path;
    
	public $htmlOptions=array('class'=>'form-control');
    
	public $fieldOptions = array();
    
    public $ajax = false;

    
	public function init() {
        $attribute = $this->attribute;
        $this->value = $this->model->$attribute;
	}
    
	public function run() {        
        echo '<a href="#" class="btn btn-default file-styled"><i class="fa fa-download fa-before"></i>&nbsp;&nbsp;&nbsp;Выберите файл...</a>';
        
        if ($this->ajax)
            $fieldClasses = 'hidden file-styled-field file-ajax-upload';
        else
            $fieldClasses = 'hidden file-styled-field';
        echo CHtml::activeFileField($this->model, $this->attribute, array_merge($this->fieldOptions, array('class' => $fieldClasses)));
        
        if (!empty($this->value) && !empty($this->path))
            echo '&nbsp;&nbsp;'.CHtml::link('<i class="fa fa-file-picture-o"></i>', Yii::app()->request->hostInfo.'/'.$this->path.$this->value, array('class' => 'btn btn-primary btn-outline', 'target' => '_blank'));
        
        echo '<span class="help-block m-b-none">'.CHtml::error($this->model, $this->attribute).'</span>';
        
        if (!empty($this->value) && !empty($this->delete_filename)) {
            echo '<div class="checkbox checkbox-danger">';            
            echo CHtml::checkBox($this->delete_filename, '', array('id' => $this->delete_filename));
            echo CHtml::label('Удалить файл', $this->delete_filename);            
            echo '</div>';
        }
	}
}
