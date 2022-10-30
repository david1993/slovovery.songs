<?php defined('SYSPATH') or die('No direct script access.');
class Model_Search extends ORM {

	public function getResults($values){
		$keywordsArray = array();
		$keyword = ORM::factory('keyword');
		foreach ($values as $value){
			$keyword_id = $keyword->get_keyword_id($value);
			($keyword_id != '') ? array_push($keywordsArray, $keyword_id) : '';
		}
		if (empty($keywordsArray))
			return false;
		else {
			$tovars = array();
			$query = DB::select('tovar_id')
				->distinct(TRUE)
				->from('tovars_keywords')
				->where('keyword_id','IN',$keywordsArray)
				->group_by('weight')
				->execute($this->_db);
			foreach ($query as $item){
				($item != '') ? array_push($tovars, $item['tovar_id']) : '';
			}
			return $tovars;
		}
	}
}
?>