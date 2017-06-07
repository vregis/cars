<?php
/**
 * phaEditColumn class file.
 *
 * @author Vadim Kruchkov <long@phargo.net>
 * @link http://www.phargo.net/
 * @copyright Copyright &copy; 2011 phArgo Software
 * @license GPL & MIT
 */
class phaPriceColumn extends phaAbsActiveColumn {

    /**
     * @var array Additional HTML attributes. See details {@link CHtml::inputField}
     */
    public $htmlEditFieldOptions = array();
    
    public $priceType = '';
    
    public $currency = '';

    /**
     * Renders the data cell content.
     * This method evaluates {@link value} or {@link name} and renders the result.
     *
     * @param integer $row the row number (zero-based)
     * @param mixed $data the data associated with the row
     */
    protected function renderDataCellContent($row,$data) {
        //$value = CHtml::value($data, $this->name);
        $value = $data->getPriceByType($this->priceType, $this->currency);
        $valueId = $data->{$this->modelId};

        $this->htmlEditFieldOptions['itemId'] = $valueId;
        $fieldUID = $this->getViewDivClass();

        echo CHtml::tag('div', array(
            'valueid' => $valueId,
            'id' => $fieldUID.'-'.$valueId,
            'class' => $fieldUID
        ), $value);

        echo CHtml::openTag('div', array(
            'style' => 'display: none;',
            'id' => $this->getFieldDivClass() . $data->{$this->modelId},
            'data-id' => $data->id,
            'data-price-type' => $this->priceType,
            'data-currency' => $this->currency,
        ));
        echo CHtml::textField($this->name.'[' . $valueId . ']', $value, $this->htmlEditFieldOptions);
        echo CHtml::closeTag('div');
    }

    /**
     * @return string Name of div's class for view value
     */
    protected function getViewDivClass( ) {
        return 'viewValue-' . $this->id;
    }

    /**
     * @return string Name of div's class for edit field
     */
    protected function getFieldDivClass( ) {
        return 'field-' . $this->id . '-';
    }

    /**
     * Initializes the column.
     *
     * @see CDataColumn::init()
     */
    public function init() {
        parent::init();
 
        $cs=Yii::app()->getClientScript();
 
        $liveClick ='
/*        phaACActionUrls["'.$this->grid->id.'"]="' . $this->buildActionUrl() . '"; */
        phaACActionUrls["'.$this->id.'"]="' . $this->buildActionUrl() . '";
        jQuery(document).on("click", ".'. $this->getViewDivClass() . '", function(){
            phaACOpenEditField(this, "' . $this->id . '");
            return false;
        });';
 
        $script ='
        var phaACOpenEditItem = 0;
        var phaACOpenEditGrid = "";
        var phaACActionUrls = [];
        function phaACOpenEditField(itemValue, gridUID, grid ) {
            phaACHideEditField( phaACOpenEditItem, phaACOpenEditGrid );
            var id   = $(itemValue).attr("valueid");
 
            $("#viewValue-" + gridUID + "-"+id).hide();
            $("#field-" + gridUID + "-" + id).show();
            $("#field-" + gridUID + "-" + id+" input")
                .focus()
                .keydown(function(event) {
                    switch (event.keyCode) {
                       case 27:
                          phaACHideEditField( phaACOpenEditItem, gridUID );
                       break;
                       case 13:
/*                          phaACEditFieldSend( itemValue ); */
                          phaACEditFieldSend( itemValue, gridUID );
                       break;
                       default: break;
                    }
                });
            $("#field-" + gridUID + "-" + id+" input").blur(function() {
                phaACEditFieldSend( itemValue, gridUID );
            });
 
            phaACOpenEditItem = id;
            phaACOpenEditGrid = gridUID;
        }
        function phaACHideEditField( itemId, gridUID ) {
            var clearVal = $("#viewValue-" + gridUID + "-"+itemId).text();
            $("#field-" + gridUID + "-" + itemId+" input").val( clearVal );
            $("#field-" + gridUID + "-" + itemId).hide();
            $("#field-" + gridUID + "-" + itemId+" input").unbind("keydown");
            $("#viewValue-" + gridUID + "-" + itemId).show();
            phaACOpenEditItem=0;
            phaACOpenEditGrid = "";
        }
/*        function phaACEditFieldSend( itemValue ) { */
        function phaACEditFieldSend( itemValue, gridUID ) {
            var id = $(itemValue).parents(".grid-view").attr("id");
            $("#field-"+phaACOpenEditGrid+"-"+phaACOpenEditItem+" input").addClass("loading");
            $.ajax({
                type: "POST",
                dataType: "json",
                cache: false,
/*                url: phaACActionUrls[id], */
                url: phaACActionUrls[gridUID],
                data: {
                    product_id: $("#field-"+phaACOpenEditGrid+"-"+phaACOpenEditItem+"").attr("data-id"),   
                    price_type: $("#field-"+phaACOpenEditGrid+"-"+phaACOpenEditItem+"").attr("data-price-type"),   
                    currency: $("#field-"+phaACOpenEditGrid+"-"+phaACOpenEditItem+"").attr("data-currency"),                    
                    value: $("#field-"+phaACOpenEditGrid+"-"+phaACOpenEditItem+" input").val()
                },
                success: function(data){
                    $("#"+id).yiiGridView.update( id );
                    $("#field-"+phaACOpenEditGrid+"-"+phaACOpenEditItem+" input").removeClass("loading");
                    $("#field-"+phaACOpenEditGrid+"-"+phaACOpenEditItem+" input").addClass("loading_successfull");
                }
            });
        }
        ';
 
        $cs->registerScript(__CLASS__.'#active_column-edit', $script);
        $cs->registerScript(__CLASS__.$this->grid->id.'#active_column_click-'.$this->id, $liveClick);
    }
}