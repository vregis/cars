<?php

class FormFeedback extends CModel
{
    public $name, $email, $reason, $notes;
    
    public $reasons = array('Problems with Account', 'Payment Issues', 'Other reason');
    
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, reason, notes', 'required', 'message' => 'Please, fill the field.'),
			array('email', 'email'),
		);
	}
    
    
	public function attributeNames()
	{
		return array(
			'name' => 'Name',
			'email' => 'E-mail',
			'reason' => 'Reason',
			'notes' => 'Message',
		);
	}
    
    
	public function attributeLabels()
	{
		return array(
			'name' => 'Name',
			'email' => 'E-mail',
			'reason' => 'Reason',
			'notes' => 'Message',
		);
	}
}