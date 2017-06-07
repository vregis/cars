<?php
Yii::import('zii.widgets.grid.CDataColumn');

class feOrderTitleColumn extends CDataColumn
{    
    public function getDataCellContent($row)
	{        
        $data = $this->grid->dataProvider->data[$row];
        if ($this->value!==null)
			$data = $this->evaluateExpression($this->value, array('data'=>$data, 'row'=>$row));
        
        $offer = $data->offer;
        
		if (!empty($offer->primaryPhoto))
            $img_src = Yii::app()->request->hostInfo.'/resources/offers/200_'.$offer->primaryPhoto->filename;
        else
            $img_src = Yii::app()->theme->baseUrl.'/img/blank_offer.png';
        
        if (Yii::app()->user->id == $data->client_id)
            $link = array('/orders/default/edit', 'id' => $data->id);
        else
            $link = array('/orders/offered/view', 'id' => $data->id);
        
        $ret = CHtml::link(CHtml::image($img_src, $offer->title, array('class' => 'img-responsive')), $link, array('class' => 'archived-offer-preview'));
        $ret .= CHtml::link($offer->title, $link, array('class' => 'archived-offer-link'));        
        $ret .= ' '.Yii::t('app', 'ordered by').' '.CHtml::link($data->client->profile->name, array('/user/profile/view', 'id' => $data->client_id));
        
        return $ret;
	} 
}