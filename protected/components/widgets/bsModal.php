<?php
class bsModal extends CWidget
{
    
	public $header = 'Notification!';
    
	public $body = '';
    
	public $footer = '';
    
	public function init() {
	}
    
	public function run() {
        $this->render('bsModalWidget', array('header' => $this->header, 'body' => $this->body, 'footer' => $this->footer));
	}
}
