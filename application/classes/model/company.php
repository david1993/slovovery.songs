<?php defined('SYSPATH') or die('No direct script access.');
class Model_Company extends ORM {
	
	protected $_belongs_to = array(
            'user' => array(
                   'model' => 'user',
                   'foreign_key' => 'user_id'
            )
            );
	
	public function labels()
	{
		return array(
			'company_name'		=> 'Название',
			'opf'		=> 'Юр. название',
			'law_name'		=> '',
			'url'	=> 'URL сайта',
			'city'		=> 'Город',
			'address'	=> 'Адрес',
			'phone'		=> 'Телефон',
			'description'		=> 'Описание',
		);
	}
	
	public function opfs()
	{
		return array(
			'ИП' => 'ИП',
			'ООО' => 'ООО',
			'ЗАО' => 'ЗАО',
			'ОАО' => 'ОАО',
			'ГУП' => 'ГУП',
		);
	}
	
	public function rules()
	{
	    return array(
	        'company_name' => array(
	            array('not_empty'),
		        array('max_length', array(':value', 250)),
	        ),
	        
	    );
	}
	
	
	public function filters()
	{
	    return array(
	        'name' => array(
	            array('trim'),
	        ),
			'law_name' => array(
	            array('trim'),
	        ),
	    );
	}
	
	public function create_company($values, $expected)
	{ 
		return $this->values($values, $expected)->create();
	}
	
	public function edit_company($values, $expected, Model_User $user)
	{	
		
		$validation = Validation::factory($values)
						->rule('law_name', 'not_empty')
						->rule('law_name', 'max_length', array(':value', 250))
						->rule('city', 'not_empty')
						->rule('address', 'not_empty')
						->rule('phone', 'not_empty')
						->rule('url', 'url')
						->label('law_name', 'Юр. название')
						->label('city', 'Город')
						->label('url', 'URL сайта')
						->label('address', 'Адрес')
						->label('phone', 'Телефон');
					
		if( !$validation->check())
		{
			$errors = $validation->errors('validation');
			return true;
		}		
				
		foreach($expected as $name) $user->company->$name = $values[$name];
		$user->save();
		$user->company->save();
	}
	
}        
    