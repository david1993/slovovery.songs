<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Search extends Controller_Layout {
	
	public function action_index()
    {
		$this->template->navibar = View::factory('page/navibar')->set('nav',Controller_Page::nav());
		$this->template->h1 = 'Результаты поиска';
    	if (HTTP_Request::GET == $this->request->method()){
			$q = $this->request->query('q');
			if (!empty($q)){
			
				$q = preg_replace ("/[^a-zA-ZА-Яа-пр-я0-9\s]/","",$q);
				while ( strpos($q,'  ')!==false ){
					$q = str_replace('  ',' ',$q);
				};
				$keywords = explode(" ", $q);
				$keyword = ORM::factory('keyword');
				$results = ORM::factory('search', 1)->getResults($keywords);
				if($results) {
					$tovars=ORM::factory('tovar')
						->where('id','IN', $results)
						->find_all();
				}
				
				$this->template->search = View::factory('page/search')
					->bind('q', $q);
				$this->template->content = View::factory('search/results')
					->bind('q', $q)
					->bind('tovars', $tovars);
			}
			else {
				$this->request->redirect('/');
			}
		}
    }
}