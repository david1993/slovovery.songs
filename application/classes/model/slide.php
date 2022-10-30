<?php defined('SYSPATH') or die('No direct script access.');
class Model_Slide extends ORM {
	const STATUS_DRAFT = 1;
	const STATUS_MODERATION = 2;
	const STATUS_REJECTED = 3;
	const STATUS_PUBLISHED = 4;
	
	const PIC_PATH = './images/shops/';
	const MINI_PIC_PATH = './images/shops/mini/';
	


	protected $_belongs_to = array('song' => array('model' => 'song', 'foreign_key' => 'id_song'));
	
	
	public function labels()
	{
		return array(
			'name'		=> 'Название',
			'shoptype' => 'Тип магазина',
			'kind' => 'Разновидность магазина',
			'description'		=> 'Описание',
			'city'	=> 'Город',
			'address'	=> 'Адрес',
			'url' => 'URL магазина',
			'shopservice' => 'Услуги',
			'phone' => 'Телефон',
			'email' => 'E-mail для приема заявок с mebelboom'
		);
	}
	
	public function feedback_labels()
	{
		return array(
			'name'		=> 'Ваше имя',
			'phone'		=> 'Ваш телефон',
			'email'		=> 'Ваш e-mail',
			'message'	=> 'Сообщение',
		);
	}
	
	public function amount_control($values)
	{	
		return sizeof($values)<=8;
	}
	
	
	public function valid_feedback($values,$expected)
	{
		$validation = Validation::factory($values);
		$validation	->	rule('email','not_empty',array(':value'));
		$validation	->	rule('email', 'email',array(':value'));
		$validation	->	rule('message','not_empty',array(':value'));
		$validation	->	label('email','Ваш e-mail');
		$validation	->	label('message','Сообщение');
		return $this->check($validation);
       
	}
	
	public function valid_shop_def($values){
		return Validation::factory($values)
			->rule('name', 'not_empty')
			->rule('name','max_length', array(':value', 250))
			->rule('address', 'not_empty')
			->rule('address','max_length', array(':value', 250))
			->rule('phone', 'not_empty')
			->rule('email', 'not_empty')
			->rule('email', 'email')
			->label('name','Название')
			->label('address','Адрес')
			->label('phone','Телефон')
			->label('email','E-mail');
	}
	
	public function valid_shop_inet($values){
		return Validation::factory($values)
			->rule('name', 'not_empty')
			->rule('name','max_length', array(':value', 250))
			->rule('url','not_empty')
			->rule('url','url')
			->rule('city','not_empty')
			->rule('email', 'not_empty')
			->rule('phone', 'not_empty')
			->rule('email', 'email')
			->label('name','Название')
			->label('city','Город')
			->label('phone','Телефон')
			->label('email','E-mail')
			->label('url','URL магазина');
	}
	
	public function save_images(){
		$count = count($_FILES['images']['name']);
		$path = self::PIC_PATH.$this->id."/";
		if(! file_exists($path))
		{
			mkdir($path, 0777, true);
		}
		
		if(! file_exists(self::MINI_PIC_PATH.$this->id))
		{
			mkdir(self::MINI_PIC_PATH.$this->id, 0777, true);
		}
		
		for($i = 0; $i < $count;$i++)
		{
			
			$filename = preg_replace('/\s+/u', '_', $_FILES['images']['name'][$i]);
			if($filename)
			{
				Upload::save_a($_FILES['images'], $filename , $path, $i, 0777);
				Image::factory($path.$filename)->resize(480,NULL)->save(self::MINI_PIC_PATH.$this->id."/".$filename, 80);
			}
		}
	}
	
	public function get_images($number = null){
		$path = self::PIC_PATH.$this->id;
		$images = array();
		if(file_exists($path))
		foreach (scandir($path) as $file) {
			if (preg_match("/\.(jpg|jpeg|png|gif)$/", $file, $matches)) 
			if($number==array_push($images, $file)) break;
		}
		
		return $images;
	}
	
	public function create_shop($values,$expected)
	{
		$this->user_id = Auth::instance()->get_user();
		
		if($values['kind_id'] == 1)
		{
			$validation = $this -> valid_shop_def($values);
		}
		elseif($values['kind_id'] == 2)
		{
			$validation = $this -> valid_shop_inet($values);
		}
		return $this->values($values, $expected)->save($validation);
		
		$this->values($values,$expected);
		
		if(isset($_FILES['images']))
		{
			
			$pic_validation = Validation::factory($_FILES)
			->rule('images','Upload::type_a', array(':value', array('jpg','jpeg', 'png', 'gif')))
			->rule('images','Upload::size_a', array(':value', '1M'));
			
			
			$this->check($pic_validation);
			
		}
		
		/*if($values['do'] == 'publish'){
			if(Auth::instance()->logged_in('admin'))
			{
				$this->publish(); //Опубликовать
			}
			else
			{
				$this->moderate();//Идет проверка модератором
			}
		}
		else
		{
			$this->draft(); //Черновик
		}*/
        return $this->create();
	}
	
	public function save_shop($values,$expected)
	{	
		if($values['kind_id'] == 1)
		{
			$validation = $this -> valid_shop_def($values);
		}
		elseif($values['kind_id'] == 2)
		{
			$validation = $this -> valid_shop_inet($values);
		}
		
		
		
		$this->values($values, $expected);
		
		if(isset($_FILES['images']))
		{
			$pic_validation = Validation::factory($_FILES)
			->rule('images','Upload::type_a', array(':value', array('jpg','jpeg', 'png', 'gif')))
			->rule('images','Upload::size_a', array(':value', '1M'));
			
			$this->check($pic_validation);
			
			$this->save_images();
		}
		
		$this->save($validation);
	}
	
	public function publish()
	{
		if(! $this->published())
		{
			$this->status_id = Model_Shop::STATUS_PUBLISHED;
		}
		return $this;
	}
	
	public function published()
	{
		return $this->status_id == Model_Shop::STATUS_PUBLISHED;
	}
	
	public function moderate()
	{
		if($this->status_id != Model_Shop::STATUS_MODERATION)
		{
			$this->status_id = Model_Shop::STATUS_MODERATION;
		}
		//TODO Отправить уведомление модератору
		return $this;
	}
	
	public function draft()
	{
		$this->status_id = Model_Shop::STATUS_DRAFT;
		return $this;
	}
	
	public function deleteIds(Array $ids){
		DB::delete($this->_table_name)
		->where('id','IN', $ids)
		->and_where('user_id', '=', Auth::instance()->get_user()->id)
		->execute($this->_db);
	}
	
	public function tovars_count($user_id)
	{
		$query = DB::query(Database::UPDATE, "UPDATE shops,(SELECT shop_id,COUNT(*) as tovars_count FROM shops_tovars, shops WHERE id = shop_id AND user_id = {$user_id} GROUP BY shop_id) as tc SET shops.tovars_count=tc.tovars_count WHERE shops.id=shop_id");
		return 	$query->execute($this->_db);
	}

    //TODO:Написать что делает функция
	public function get_tovars_for_shop_of_user() {
		$user_id = Auth::instance()->get_user()->id;
		return  DB::query(Database::SELECT, "SELECT DISTINCT tovar.id, tovar.name, 
															case
																when st.shop_id = {$this->id} then st.price
																else ''
															end as price,
															case
																when st.shop_id = {$this->id} then st.url
																else ''
															end as url,
															case
																when st.shop_id = {$this->id} then st.best
																else ''
															end as best,
															st.shop_id, tovar.category_id 
													FROM tovars as tovar LEFT JOIN shops_tovars as st ON tovar.id = st.tovar_id, tovars as tovar_o
													WHERE tovar.user_id = {$user_id} AND (st.shop_id = {$this->id} OR {$this->id} NOT IN (
														SELECT t_st.shop_id 
														FROM shops_tovars as t_st 
														WHERE tovar.id = t_st.tovar_id AND t_st.shop_id = {$this->id}) ) ORDER BY tovar.category_id")
						->execute()
						->as_array();
	}
	
}
?>