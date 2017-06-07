<?php
Yii::import('zii.widgets.grid.CDataColumn');

class feOrderPriceColumn extends CDataColumn
{    
    public function getDataCellContent($row)
	{
        $data = $this->grid->dataProvider->data[$row];
        if ($this->value!==null)
			$data = $this->evaluateExpression($this->value, array('data'=>$data, 'row'=>$row));
        
        //$price = Yii::app()->controller->formatPrice($data->total_cost);
        //$price = str_replace(' / ', '<br />', $price);
        //$ret = str_replace('span', 'big', $price);
        $ret = '';
        
        $ret .= '<span class="status-cell-label '.$data->statusClass.'">'.Orders::model()->statuses[$data->status].'</span>';
        
        return $ret;
	} 
}