<?php defined('SYSPATH') or die('No direct script access.');
class Model_User extends Model_Auth_User {
	
	protected $_has_one = array(
		'company' => array(
			'model' => 'company',
			'foreign_key' => 'user_id',
		),
		
	);
	
	protected $_has_many = array(
		'favorites' => array(
			'model' => 'tovar',
			'through'=>'favorites',
			'far_key'=>'tovar_id',
		),
		'user_tokens' => array('model' => 'user_token'),
		'roles'       => array('model' => 'role', 'through' => 'roles_users'),
	);
	
	public function feedback_labels()
	{
		return array(
			'theme'		=> 'Тема сообщения',
			'message'	=> 'Текст сообщения',
		);
	}
	
	public function rules()
	{
		return array(
			'username' => array(
				array('not_empty'),
				array('max_length', array(':value', 32)),
			),
			'password' => array(
				array('not_empty'),
			),
			'email' => array(
				array('not_empty'),
				array('email'),
			),
		);
	}
	
	public function labels()
	{
		return array(
			'username'         => 'Логин',
			'email'            => 'Электронная почта',
			'password'         => 'Пароль',
			'name'         => 'Ваше имя',
			'phone'         => 'Телефон',
			'company_name' => 'Компания',
			'post' => 'Должность',
		);
	}
	
	public function check_old_pass($old_password)
	{	
		$auth = Auth::instance();
	    return $auth->check_password($old_password);
	}
	
	public function not_equals($new_password)
	{	
		$auth = Auth::instance();
	    return !($auth->check_password($new_password));
	}
	
	public function email_unique($email)
	{	
		$user = ORM::factory('user')
			->where('email','=', $email)
			->find();
	    return !$user->loaded();
	}
	
	public function create_user($values, $expected)
	{
		
		$extra_validation = Validation::factory($values)
			->rule('password', 'min_length', array(':value', 8))
			->rule('password_confirm', 'matches', array(':validation', 'password', 'password_confirm'))
			->rule('password', 'not_empty')
			->label('password','пароль')
			->label('password_confirm','подтверждение пароля')
			->rule('company_name', 'not_empty')
			->label('company_name','Компания')
			->rule('email', array($this, 'email_unique'));

		return $this->values($values, $expected)->create($extra_validation);
	}
	
	public function create_user_loginza($values, $expected)
	{
		// Validation for passwords
		$validation = Validation::factory($values)
			->rule('password', 'min_length', array(':value', 8))
			->rule('password_confirm', 'matches', array(':validation', 'password', 'password_confirm'));

		return $this->values($values, $expected)->create($validation);
	}
	
	public function edit_user($values, $expected)
	{
		// Validation for passwords
		$validation = Validation::factory($values);
				if($values['password'])
				{
					$validation ->rule('old_password', 'not_empty');
					
				}
				$validation	->rule('password', array($this, 'not_equals'));
				$validation	->rule('old_password', array($this, 'check_old_pass'));
				$validation	->rule('password_confirm', 'matches', array(':validation', 'password', 'password_confirm'));
				$validation	->rule('password', 'min_length', array(':value', 8));
				$validation	->rule('email', 'not_empty', array(':value'));
				$validation	->rule('email', 'email', array(':value'));
				$validation	->label('password','Новый пароль');
				$validation	->label('password_confirm','Подтвердите новый пароль');
				$validation	->label('old_password','Старый пароль');
				$validation	->label('email','E-mail администратора');
				if(!$values['password'])
				{
					unset($values['password']);
				}
				
		return $this->values($values, $expected)->save($validation);
	}
	
	public function edit_admin($values, $expected)
	{
		// Validation for passwords
		$validation = Validation::factory($values);
		
		$validation	->rule('phone', 'not_empty');
		$validation	->label('phone','Телефон менеджера');
				
		return $this->values($values, $expected)->save($validation);
	}
	
	public function change_password($values, $expected)
	{
		// Validation for passwords
		$validation = Validation::factory($values);
		$validation ->rule('password', 'not_empty');
		$validation ->rule('password_confirm', 'not_empty');
		$validation ->rule('old_password', 'not_empty');
		$validation	->rule('password', array($this, 'not_equals'));
		$validation	->rule('old_password', array($this, 'check_old_pass'));
		$validation	->rule('password_confirm', 'matches', array(':validation', 'password', 'password_confirm'));
		$validation	->rule('password', 'min_length', array(':value', 8));
		$validation	->label('password','Новый пароль');
		$validation	->label('password_confirm','Подтвердите новый пароль');
		$validation	->label('old_password','Старый пароль');
		
		return $this->values($values, $expected)->save($validation);
	}
	
	public function feedback_valid($values,$expected)
	{
		$validation = Validation::factory($values);
		$validation	->	rule('theme','not_empty');
		$validation	->	rule('message', 'not_empty');
		$validation	->	label('theme','Тема сообщения');
		$validation	->	label('message','Текст сообщения');
		return $this->check($validation);
	}
	
	public function generatePassword($number)
	{
            //$number - кол-во символов в пароле
            $arr = array('a','b','c','d','e','f',
			'g','h','i','j','k','l',
			'm','n','o','p','r','s',
			't','u','v','x','y','z',
			'A','B','C','D','E','F',
			'G','H','I','J','K','L',
			'M','N','O','P','R','S',
			'T','U','V','X','Y','Z',
			'1','2','3','4','5','6',
			'7','8','9','0');

            // Генерируем пароль
		$pass = "";
		for($i = 0; $i < $number; $i++)
		{
		// Вычисляем случайный индекс массива
			$index = rand(0, count($arr) - 1);
			$pass .= $arr[$index];
		}
		return $pass;
  	}
  	
  	public function get_favorites()
  	{
  		return DB::select('tovar_id')
		->from('favorites')
		->where('user_id','=',$this->id)
		->execute($this->_db);
  	}
  	
	public function get_favorites_count()
  	{
  		return count($this->get_favorites());
  	}
  	
  	public function get_rate($modelName,$object_id)
  	{
  		return DB::select('rate')->from('users_rates')
  			->where('user_id','=',$this->id)
  			->and_where('object_id','=',$object_id)
  			->and_where('model','=',$modelName)
  			->execute()
  			->get('rate');
  	}
  	
  	public function rate($modelName,$object_id,$rate)
  	{
  		return DB::insert('users_rates',array('user_id','model','object_id','rate'))
  			->values(array($this->id,$modelName,$object_id,$rate))			
  			->execute(); 			
  	}
}       
    