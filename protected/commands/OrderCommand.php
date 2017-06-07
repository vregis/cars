<?php

class OrderCommand extends CConsoleCommand {       
    public function actionLate() {
        $criteria = new CDbCriteria;        
        $criteria->addInCondition('status', array(Orders::STATUS_NEW, Orders::STATUS_SUBMITTED, Orders::STATUS_PAYMENT));
        $criteria->compare('date_since', '<'.date('Y-m-d H:i:s'));
        
        $late_orders = Orders::model()->findAll($criteria);
        if (!empty($late_orders))
            foreach ($late_orders as $order) {
                $order->status = Orders::STATUS_CANCELED;
                $order->save();
            }
    }       
    
    
    
    /*
     * Cancel all orders, that have no change last 24 hours
     */
    public function actionLate24() {
        $criteria = new CDbCriteria;        
        $criteria->condition = '`date_changed` IS NOT NULL';
        $criteria->addInCondition('status', array(Orders::STATUS_SUBMITTED, Orders::STATUS_PAYMENT));
        
        $date = strtotime(date('Y-m-d H:i:s') . ' -1 day');        
        $criteria->compare('date_changed', '<'.date('Y-m-d H:i:s', $date));
        
        $late_orders = Orders::model()->findAll($criteria);
        if (!empty($late_orders))
            foreach ($late_orders as $order) {
                $order->status = Orders::STATUS_CANCELED;
                $order->save();
            }
    }
}