<?php
/**
 * phaCheckColumn class file.
 *
 * @author Vadim Kruchkov <long@phargo.net>
 * @link http://www.phargo.net/
 * @copyright Copyright &copy; 2011 phArgo Software
 * @license GPL & MIT
 */
class phaCheckColumn extends phaAbsActiveColumn {

    /**
     * @var array Additional HTML attributes. See details {@link CHtml::checkBox}
     */
    public $htmlCheckBoxOptions = array();

    /**
     * @var mixed The value used to determine the check state
     */
    public $checkedValue = 1;

    /**
     * Renders the data cell content.
     * This method evaluates {@link value} or {@link name} and renders the result.
     *
     * @param integer $row the row number (zero-based)
     * @param mixed $data the data associated with the row
     */
    protected function renderDataCellContent($row,$data) {
        $value = CHtml::value($data, $this->name);
        if (empty($value)) {
            $field = $this->name;
            $value = $data->$field;
        }
        
        $this->htmlCheckBoxOptions['itemId'] = $data->{$this->modelId};
        $this->htmlCheckBoxOptions['data-url'] = $this->buildActionUrl();
        $this->htmlCheckBoxOptions['class'] = 'phaCheckBoxInput';
        $this->htmlCheckBoxOptions['data-grid'] = $this->grid->getId();
        
        echo CHtml::checkBox(
            $this->name.$value,
            (boolean) $value==$this->checkedValue,
            $this->htmlCheckBoxOptions
        );
    }

    /**
     * Initializes the column.
     *
     * @see CDataColumn::init()
     */
    public function init() {
        parent::init();

        if (!isset($this->htmlCheckBoxOptions['class'])) {
            $this->htmlCheckBoxOptions['class'] = 'checkBoxColumn-' . $this->id;
        }

        $cs=Yii::app()->getClientScript();
        $gridId = $this->grid->getId();

        $script ='enableCheckBoxInput();';

        $cs->registerScript(__CLASS__.$gridId.'#active_column-'.$this->id.date('U'), $script);
    }
}