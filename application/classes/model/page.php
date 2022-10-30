<?php defined('SYSPATH') or die('No direct script access.');

class Model_Page extends ORM {
	
	
	public function feedback_labels()
	{
		return array(
			'name'		=> 'Ваше имя',
			'phone'		=> 'Ваш телефон',
			'email'		=> 'Ваш e-mail',
			'message'	=> 'Сообщение',
		);
	}
	
	
	public function feedback_valid($values,$expected)
	{
		$validation = Validation::factory($values);
		$validation	->	rule('email','not_empty',array(':value'));
		$validation	->	rule('email', 'email',array(':value'));
		$validation	->	rule('message', 'not_empty',array(':value'));
		$validation	->	label('email','Ваш e-mail');
		$validation	->	label('message','Сообщение');
		return $this->check($validation);
	}
	
}
    