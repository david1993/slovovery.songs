<?php defined('SYSPATH') or die('No direct script access.');

class Model_Song extends ORM
{
	const STATUS_NEW = 1;
	const STATUS_EDITED = 2;
	const STATUS_CHECHED = 3;
	const STATUS_MAYBEDUBLICATE = 4;// песня новая, но возможно дубликат
	//const STATUS_PUBLISHED = 4;
	const STATUS_OVERWRITED = 5;

	const PIC_PATH = './images/';
	const MINI_PIC_PATH = './images/mini/';

	protected $_has_many = array(
		'slides' => array(
			'model' => 'slide',
			'foreign_key' => 'id_song',
		),
		'accords' => array(
			'model' => 'accord',
			'foreign_key' => 'id_song',
		),
	);

	protected $_created_column = array('column' => 'created_time', 'format' => true);

	public static function rss_header()
	{
		return array(
			'title' => 'mebelboom.com',
			'language' => 'ru',
			'description' => 'Акции',
			'link' => 'http://mebelboom.com/stock/rss',
			'copyright' => 'Copyright 2012',
			'pubDate' => time(),
		);
	}

	public function statuses()
	{
		return array(
			'',
			'Черновик',
			'Идет проверка модератором',
			'Отклонено модератором',
			'Размещено на сайте',
			'Истек срок размещения',
		);
	}

	public function status()
	{
		return Arr::get($this->statuses(), $this->status_id);
	}

	public function labels()
	{
		return array(
			'name' => 'Название',
			'anons' => 'Краткое описание',
			'begin_time' => 'Дата начала',
			'content' => 'Подробное описание',
			'pic' => 'Изображение',
			'url' => 'URL страницы с подробной информацией',
		);
	}

	public static function mod_labels()
	{
		return array(
			'name' => 'Название',
			'status_id' => 'Статус',
			'reject_reason' => 'Комментарий',
		);
	}

	public function rules()
	{

		return array(/*
	        'name' => array(
	            array('not_empty'),
		        array('max_length', array(':value', 250)),
	        ),
			 'anons' => array(
	            array('not_empty'),
	        ),
			 'begin_time' => array(
	            array('not_empty'),
	        ),
	        'url' => array(
	            array('url'),
	        ),*/
		);

	}

	public function filters()
	{
		return array(
			'name' => array(
				array('trim'),
			),
		);
	}

	public function save_pic()
	{
		$path = self::PIC_PATH;
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		if (!file_exists(self::MINI_PIC_PATH)) {
			mkdir(self::MINI_PIC_PATH, 0777, true);
		}
		$filename = preg_replace('/\s+/u', '_', $_FILES['pic']['name']);
		Upload::save($_FILES['pic'], $filename, $path, 0777);
		Image::factory($path . $filename)->resize(600, null)->save(self::MINI_PIC_PATH . $filename, 80);
		$this->pic = $filename;
	}


	public function create_stock($values, $expected)
	{
		$this->user_id = Auth::instance()->get_user();

		$values['begin_time'] = $values['begin_time'] ? strtotime($values['begin_time']) : "";

		$this->values($values, $expected);

		if (isset($_FILES['pic']) && $_FILES['pic']['error'] == UPLOAD_ERR_OK) {
			$pic_validation = Validation::factory($_FILES)
				->rule('pic', 'Upload::size', array(':value', '1M'))
				->rule('pic', 'Upload::type', array(':value', array('jpg', 'jpeg', 'png', 'gif')));

			$this->check($pic_validation);
			$this->save_pic();
		}

		if ($values['do'] == 'publish') {
			if (Auth::instance()->logged_in('admin')) {
				$this->publish(); //Опубликовать
			} else {
				$this->moderate();//Идет проверка модератором
			}
		} else {
			$this->draft(); //Черновик
		}
		return $this->create();
	}

	public function save_stock($values, $expected)
	{
		$values['begin_time'] = isset($values['begin_time']) ? strtotime($values['begin_time']) : "";

		$this->values($values, $expected);

		if (isset($_FILES['pic']) && $_FILES['pic']['error'] == UPLOAD_ERR_OK) {
			$pic_validation = Validation::factory($_FILES)
				->rule('pic', 'Upload::size', array(':value', '1M'))
				->rule('pic', 'Upload::type', array(':value', array('jpg', 'png', 'gif')));

			$this->check($pic_validation);
			$this->save_pic();
		}

		if (Auth::instance()->logged_in('admin')) {
			switch ($this->status_id) {

				case 3:
					$this->reject($values['reject_reason']);
					break;
				case 4:
					$this->publish(); //Опубликовать
					break;
				default:
					$this->moderate();//Идет проверка модератором
			}
		} else {
			if ($values['do'] == 'publish') {
				$this->moderate();//Идет проверка модератором
			} else {
				$this->draft(); //Черновик
			}
		}


		return $this->save();
	}


	public function publish()
	{
		if (!$this->published()) {
			$this->status_id = Model_Stock::STATUS_PUBLISHED;
			$this->publish_time = time();
			$this->reject_reason = null;
		}
		return $this;
	}

	public function published()
	{
		return $this->active == 1;
	}

	public function moderate()
	{
		if ($this->status_id != Model_Stock::STATUS_MODERATION) {
			$this->status_id = Model_Stock::STATUS_MODERATION;
			$this->publish_time = time();
		}
		//TODO Отправить уведомление модератору
		return $this;
	}

	public function reject($reason = null)
	{
		$this->reject_reason = $reason;
		$this->status_id = Model_Stock::STATUS_REJECTED;
		return $this;
	}

	public function draft()
	{
		$this->status_id = Model_Stock::STATUS_DRAFT;
		return $this;
	}

	public function setParamUpdated($val)
	{
		$query = DB::query(Database::UPDATE, "UPDATE songs SET updated=$val WHERE id=$this->id");
		return $query->execute($this->_db);
	}

	public function getH1FromSlide($firstSlide)
	{
		$pos = strpos($firstSlide, '<br>');
		if (!$pos) {
			$pos = strpos($firstSlide, '<br/>');
		}
		if ($pos) {
			$h1 = substr($firstSlide, 0, $pos);
		} else {
			$h1 = $firstSlide;
		}
		return trim($h1, '- ,.:;');

	}

	public function getH1FromFileName($filename)
	{
		$arr = explode(".", $filename);
		unset($arr[count($arr) - 1]);
		return implode($arr);
	}

	public function getYakors($songs)
	{
		$yakor = '';
		$return = array();
		foreach ($songs->as_array() as $song) {
			$name = $song->name;
			$n = substr($name, 0, 2);
			$newYakor = strtoupper($n);

			if ($newYakor != $yakor) {
				$yakor = $newYakor;
				$return[] = array('id' => $song->id, 'name' => $yakor);
			}
		}
		return $return;

	}

	public function getFilterFields()
	{
		$filterFields = array();
		$filterFields['accords'] = array(
			'default' => 0,
			'type' => 'input-radio',
			'name' => 'Аккорды',
			'values' => array('0' => 'все', '1' => 'с аккордами'/*,'2'=>'без аккордов'*/)
		);
		$filterFields['sortfield'] = array(
			'default' => 'name',
			'type' => 'input-radio',
			'name' => 'Сортировка',
			'values' => array('name' => 'По названию', 'created_time' => 'По дате добавления')
		);
		$filterFields['sorttype'] = array(
			'default' => 'asc',
			'type' => 'input-radio',
			'name' => 'Порядок сортировки',
			'values' => array('asc' => 'По возрастанию', 'desc' => 'По убыванию')
		);
		//$filterFields['perPage']=array('default'=>'300','type'=>'input-text','name'=>'Количество на странице');
		return $filterFields;
	}

}        
    