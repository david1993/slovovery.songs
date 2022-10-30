<?php defined('SYSPATH') or die('No direct script access.');

class Model_Pesni extends ORM {
	
	const FILE_PATH = './files/pesni/';
	
	public function getFilterFields(){
		$filterFields=array();
		$filterFields['accords']=array('default'=>0,'type'=>'input-radio','name'=>'Аккорды','values'=>array('0'=>'все','1'=>'с аккордами'/*,'2'=>'без аккордов'*/));
		$filterFields['sortfield']=array('default'=>'title','type'=>'input-radio','name'=>'Сортировка','values'=>array('title'=>'По названию','id'=>'По дате добавления','text'=>'По текстам'));
		$filterFields['sorttype']=array('default'=>'asc','type'=>'input-radio','name'=>'Порядок сортировки','values'=>array('asc'=>'По возрастанию','desc'=>'По убыванию'));
		//$filterFields['perPage']=array('default'=>'300','type'=>'input-text','name'=>'Количество на странице');
		return $filterFields;
	}
	
	public function labels()
	{
		return array(
				'title'		=> 'Название',
				'text'		=> 'Текст песни',
				'accords'=> 'аккорды',
				'fileMp3'		=> 'Изображение'
		);
	}
	public function save_file($song_id){
		$count = count ( $_FILES ['filemp3'] ['name'] );
		$path = self::FILE_PATH . $song_id . "/";
		$out = array ();
		if (! file_exists ( $path )) {
			mkdir ( $path, 0777, true );
		}
		
		
		//очистим папку
		$dir=$path;
		
	 $list = scandir($dir);
    unset($list[0],$list[1]);
		
		foreach ($list as $file)
		{
			if (is_dir($dir.$file))
			{
				clear_dir($dir.$file.'/');
				rmdir($dir.$file);
			}
			else
			{
				unlink($dir.$file);
			}
		}
		
		//добавляем 1 раз
		
		//print_r($_FILES);
		
		for($i = 0; $i < $count; $i ++) {
				
			$filename = preg_replace ( '/\s+/u', '_', $_FILES ['filemp3'] ['name'] );
			if ($filename) {
				Upload::save ( $_FILES ['filemp3'], $filename, $path, 0777 );
				
			
				
				$this->filemp3 = $filename;
				$this->save ();
			}
			break;
		}
	}
}
    