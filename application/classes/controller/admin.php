<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin extends Controller_Layout {
	
	public $auth_required = 'admin';
	
	public $template = 'admin';
	
	public static function nav() { 
		return array(
					'Контент'=>array('href'=>'/admin/content/'),
					'Акции'=>array('href'=>'/admin/stock/'),
					'Отзывы'=>array('href'=>'/admin/comment/'),
					'Продавцы'=>array('href'=>'/admin/company/'),
					'Города'=>array('href'=>'/admin/city/'),
					'Настройки'=>array('href'=>'/admin/settings/'),
				); 
	}
	public function before()
	{
		parent::before();
		$this->template->navibar = View::factory('admin/navibar')->set('nav',$this->nav());
		if (!Auth::instance()->logged_in('admin'))
        {
           	Request::current()->redirect('user/index');
        }
	}
	
	public function action_index()
	{
	}
	
	public function action_content()
	{	
		$this->template->h1 = 'Контент';
		$this->template->navibar->nav['Контент']['class'] = 'active';  
		$this->template->toolbar = View::factory('admin/content/toolbar');
		$this->template->content = View::factory('admin/content')->bind('pagination',$pagination)->bind('pages',$pages);
		
		$count = ORM::factory('page');
		
		$pages = clone $count;
		
		$count =$count->count_all();
		$per_page = Arr::get($_GET,'per_page',5);
		$page_num = Arr::get($_GET,'page',1);
		$offset   = ($page_num - 1) * $per_page;
			
		$pages = $pages->offset($offset)->limit($per_page)->find_all();
				
		$pagination = Pagination::factory( array(
			'total_items' => $count,
			'items_per_page' => $per_page,
			'view' => 'pagination/withcount',
			'first_page_in_url' => true
		))
			->route_params( array(
				'controller' => $this->request->controller(),
				'action' => $this->request->action()
			));		
		
	}
	
	public function action_company()
	{	
		$this->template->h1 = 'Продавцы';
		$this->template->navibar->nav['Продавцы']['class'] = 'active';
		
		$this->template->content = View::factory('admin/company')
									->bind('files',$files)
									->bind('keyword',$keyword)
									->bind('pagination',$pagination)
									->bind('companies',$companies);
									
		$files = ORM::factory('file');
		
		$files = $files->where('status', '=', '0')->find_all();
									
		$count = ORM::factory('company');
		
		$keyword = Arr::get($_GET,'keyword','');
		
		if (!empty($keyword)) $count->where('company_name', 'LIKE', "%$keyword%");
		
		$companies = clone $count;
		
		$count =$count->count_all();
		$per_page = Arr::get($_GET,'per_page',5);
		$page_num = Arr::get($_GET,'page',1);
		$offset   = ($page_num - 1) * $per_page;
			
		$companies = $companies->offset($offset)->limit($per_page)->find_all();
				
		$pagination = Pagination::factory( array(
			'total_items' => $count,
			'items_per_page' => $per_page,
			'view' => 'pagination/withcount',
			'first_page_in_url' => true
		))
			->route_params( array(
				'controller' => $this->request->controller(),
				'action' => $this->request->action()
			));		
		
	}
	
	public function action_stock()
	{
		$this->template->h1 = 'Очередь на модерацию';
		$this->template->navibar->nav['Акции']['class'] = 'active';  
    	//$this->template->toolbar = View::factory('user/stocks/toolbar');
    	$this->template->content = View::factory('admin/stock')
    	->bind('stocks',$stocks)
    	->bind('pagination',$pagination);
    	
    	$per_page = 5;
    	$page_num = Arr::get($_GET,'page',1);
    	$offset   = ($page_num - 1) * $per_page;

    	$user=Auth::instance()->get_user();
    	
    	$count=ORM::factory('stock')
    	->where('status_id','=', Model_Stock::STATUS_MODERATION)
    	->count_all();
    	
    	$stocks=ORM::factory('stock')
    	->where('status_id','=', Model_Stock::STATUS_MODERATION)
    	->order_by('begin_time')
    	->offset($offset)
    	->limit($per_page)
    	->find_all();

    	$pagination = Pagination::factory( array(
	      'total_items' => $count,
	      'items_per_page' => $per_page,
	      'view' => 'pagination/withcount',
	      'first_page_in_url' => true
    	))
    	->route_params( array(
	        'controller' => $this->request->controller(),
	        'action' => $this->request->action(),
    	));
	}
	
	public function action_city()
	{	
		$this->template->h1 = 'Список городов';
		$this->template->navibar->nav['Города']['class'] = 'active';  
		$this->template->toolbar = View::factory('admin/city/toolbar');
		$this->template->content = View::factory('admin/city')->bind('pagination',$pagination)->bind('cities',$cities);
		
		$count = ORM::factory('city');
		
		$cities = clone $count;
		
		$count =$count->count_all();
		$per_page = Arr::get($_GET,'per_page',5);
		$page_num = Arr::get($_GET,'page',1);
		$offset   = ($page_num - 1) * $per_page;
			
		$cities = $cities->offset($offset)->limit($per_page)->find_all();
				
		$pagination = Pagination::factory( array(
			'total_items' => $count,
			'items_per_page' => $per_page,
			'view' => 'pagination/withcount',
			'first_page_in_url' => true
		))->route_params( array(
			'controller' => $this->request->controller(),
			'action' => $this->request->action()
		));	
	}
	
	public function action_settings()
	{	
		$this->template->h1 = 'Настройки';
		$this->template->navibar->nav['Настройки']['class'] = 'active';  
		$this->template->toolbar = View::factory('admin/settings/toolbar');
		$this->template->content = View::factory('admin/settings')
									->bind('errors', $errors)
									->bind('message', $message)
									->bind('values', $values);
	
    	$user = Auth::instance()->get_user();
		
		if($user)
		{
			 if (HTTP_Request::POST == $this->request->method())
			{          
				try {
					
					
					// Create the user using form values
					$user = ORM::factory('user',$user->id)->edit_admin($this->request->post(), array(
						'email',
						'name',
						'phone',						
					));
					 
					// Reset values so form is not sticky
					$_POST = array();
					 
					// Set success message
					$message = "Данные успешно отредактированы."; 
					 
				} catch (ORM_Validation_Exception $e) {
					// Set errors using custom messages
					$errors = $e->errors('models');
				}
				
				$values = $this->request->post();
			}
			else
			{
				$values = $user->as_array();
			}
		}
		else
		{
			Request::current()->redirect('user/login');
		}
	}
	
	public function action_access()
	{	
		$this->template->h1 = 'Настройки';
		$this->template->navibar->nav['Настройки']['class'] = 'active';  
		$this->template->toolbar = View::factory('admin/access/toolbar');
		$this->template->content = View::factory('admin/access')
									->bind('errors', $errors)
									->bind('message', $message)
									->bind('values', $values);
	
    	$user = Auth::instance()->get_user();
		
		if($user)
		{
			 if (HTTP_Request::POST == $this->request->method())
			{          
				try {
					
					
					// Create the user using form values
					$user = ORM::factory('user',$user->id)->change_password($this->request->post(), array(
						'password',						
					));
					 
					// Reset values so form is not sticky
					$_POST = array();
					 
					// Set success message
					$message = "Пароль успешно сохранен."; 
					 
				} catch (ORM_Validation_Exception $e) {
					// Set errors using custom messages
					$errors = $e->errors('models');
				}
				
				$values = $this->request->post();
			}
			else
			{
				$values = $user->as_array();
			}
		}
		else
		{
			Request::current()->redirect('user/login');
		}
	}
	
	public function action_service()
	{	
		$this->template->h1 = 'Стоимость платных услуг';
		$this->template->navibar->nav['Настройки']['class'] = 'active';  
		$this->template->toolbar = View::factory('admin/service/toolbar');
		$this->template->content = View::factory('admin/service')->bind('services',$services);
		
		$services = ORM::factory('service')->find_all();
		if (HTTP_Request::POST == $this->request->method())
        {
			$temp = $this->request->post();
			$cost = $temp;
			try {
				foreach ($services as $service){
				
					$service->cost = $temp[$service->id];
					$service->save();
					$_POST = array();			
				}			
			}
			catch (ORM_Validation_Exception $e) {                 
				$message = 'Не удалось внести изменения.';                 
				$errors = $e->errors('models');
			}
			$this->request->redirect('/admin/service/');		
        }
		
	}
	
	public function action_dispatch()
	{	
		$this->template->h1 = 'Рассылка';
		$this->template->navibar->nav['Настройки']['class'] = 'active';  
		$this->template->toolbar = View::factory('admin/dispatch/toolbar');
		
		$this->template->content = View::factory('admin/dispatch')
										->bind('values',$values)
										->bind('dispatch',$dispatch)
										->bind('message',$message)
										->bind('errors',$errors);
		
		$dispatch = ORM::factory('dispatch',1);
		
		if (HTTP_Request::POST == $this->request->method())
        {
			try {
				$dispatch->save_dispatch($this->request->post(),
						 array(
							'period',
							));
				$message = "Изменения успешно сохранены.";	
			}
			catch (ORM_Validation_Exception $e) { 
				$message = 'Не удалось внести изменения.';                 
				$errors = $e->errors('models');
			}
			
        }
		else
		{
			
			$values = $dispatch->as_array();
		}
		
	}
	
	public function action_comment()
	{	
		$this->template->h1 = 'Отзывы';
		$this->template->navibar->nav['Отзывы']['class'] = 'active';  
		$this->template->content = View::factory('admin/comment')
										->bind('comments',$comments)
										->bind('keyword',$keyword)
										->bind('pagination',$pagination);
										
		$count = ORM::factory('comment');
		
		$keyword = Arr::get($_GET,'keyword','');
		
		if (!empty($keyword))
					$count->where('text', 'LIKE', "%$keyword%");
		
		$comments = clone $count;
		
		$count =$count->count_all();
		$per_page = Arr::get($_GET,'per_page',5);
		$page_num = Arr::get($_GET,'page',1);
		$offset   = ($page_num - 1) * $per_page;
			
		$comments = $comments->order_by('date','desc')
							->offset($offset)
							->limit($per_page)					
							->find_all();
				
		$pagination = Pagination::factory( array(
			'total_items' => $count,
			'items_per_page' => $per_page,
			'view' => 'pagination/withcount',
			'first_page_in_url' => true
		))
			->route_params( array(
				'controller' => $this->request->controller(),
				'action' => $this->request->action()
			));		
	}
	
}
