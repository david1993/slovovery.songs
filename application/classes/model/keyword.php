<?php defined('SYSPATH') or die('No direct script access.');

class Model_Keyword extends ORM {
	
	protected $_has_many = array(
		'tovars' => array(
			'model' => 'tovar',
			'through' => 'tovars_keywords',
			'foreign_key' => 'keyword_id',
			'far_key' => 'tovar_id', 
		),
	);
	
	public function rules(){
	    return array(
	        'name' => array(
	            array('not_empty'),
				array(array($this, 'name_unique')),
			),
	    );
	}
	
	public function filters(){
	    return array(
	        'name' => array(
	            array('trim'),
				array(array($this, 'correct_keyword')),
			),
	    );
	}
	
	public static function name_unique($value){	
		$keyword = ORM::factory('keyword')
			->where('name','=', $value)
			->find();
	    return !$keyword->loaded();
	}
	
	public static function correct_keyword($value){
		//echo $value;
		//echo strtolower($value);
		return strtolower($value);
	}
	
	public static function get_keyword_id($keywordName)
	{
		$keyword = ORM::factory('keyword')
			->where('name','=', $keywordName)
			->find();
		return $keyword->id;
	}
	
	public function create_keyword($values){			
		return $this->values($values)->create();
	}
	
	public function add_keywords($values, $tovar){
		$weight = 1000;
		foreach ($values as $value){
			try {
				ORM::factory('keyword')->create_keyword(
					array(
						'name' => $value,
					)
				);
			} catch(ORM_Validation_Exception $e) {
			
			}			
			DB::insert('tovars_keywords')
				->values(array(
					$tovar->id,
					10,//$this->get_keyword_id($value),
					$weight,
				))
				->execute($this->_db);
			$weight--;
		}
	}
	
	public function addToIndex($tovar){
		$q = preg_replace ("/[^a-zA-ZА-Яа-пр-я0-9\s]/","",$tovar->name);
		while ( strpos($q,'  ')!==false ){
			$q = str_replace('  ',' ',$q);
		};
		$keywords = explode(" ", $q);
		$this->removeFromIndex($tovar);
		$this->add_keywords($keywords, $tovar);
	}
	
	public function removeFromIndex($tovar){		
		DB::delete('tovars_keywords')
			->where('tovar_id','=',$tovar->id)
			->execute($this->_db);
	}
}