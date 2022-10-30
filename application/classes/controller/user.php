<?php defined('SYSPATH') or die('No direct script access.');
class Controller_User extends Controller_Layout {
 	
	public $auth_required = FALSE;
	
	public $template = 'user';
	
	public $secure_actions=array(
		//'create'=>'admin',
		'stocks'=>'seller',
		'index'=>'login',
		'tovars'=>'seller',
		'shops'=>'seller',
		'del'=>'admin',
		'mail'=>'admin',
	);
	
	public static function nav(){ 
		return array(
					'first' => array(
						'Мои товары'=>array('href'=>'/user/tovars/'),
						'Мои акции'=>array('href'=>'/user/stocks/'),
						'Мои магазины'=>array('href'=>'/user/shops/'),
					),
					'second' => array(
						'Компания'=>array('href'=>'/company/edit/'),
						'Личные данные'=>array('href'=>'/user/edit/'),
					),
				); 
	}
	
	
	public function before()
	{
		parent::before();
		if(Auth::instance()->logged_in('seller'))
		{
			$this->template->navpills = View::factory('user/navpills')->set('nav',$this->nav());
		}
	}
	
	
  	public function action_tovars()
    {
    	$category_id = $this->request->param('id');
    	
    	$category = ORM::factory('category',$category_id);
    	$this->template->navibar = '';
		$this->template->navpills = View::factory('user/navpills')->set('nav',$this->nav());
    	$this->template->navpills->nav['first']['Мои товары']['class'] = 'active';
    	
		$user=Auth::instance()->get_user();
		
    	if( ! $category->loaded())
    	{
    		//View category tree
    		/*$this->template->breadcrumbs = View::factory('breadcrumbs')
    			->set('items',array(
    				array('name'=>'Личный кабинет', 'href'=>'/user/'),
    		));*/
    		$this->template->h1 = 'Мои товары';
    		$mebel = ORM::factory('category',1);
    		$this->template->content = View::factory('user/tovars/cattree')->set('tree',$mebel->get_subtree_for_user($user->id));
    	}
    	else
    	{
    		//View tovars list
    		/*$this->template->breadcrumbs = View::factory('breadcrumbs')
    			->set('items',array(
    				array('name'=>'Личный кабинет', 'href'=>'/user/'),
    				array('name'=>'Мои товары', 'href'=>'/user/tovars/'),
    			));*/
    		$this->template->h1 = $category->name;
			$this->template->toolbar = View::factory('user/tovars/toolbar')->set('category_id',$category_id);
		
			
			
			$count=ORM::factory('tovar')
				->where('category_id','=', $category_id)
				->where('user_id','=', $user->id);

			$tovars = clone $count;
		
			$count =$count->count_all();
			$per_page = Arr::get($_GET,'per_page',5);

			$page_num = Arr::get($_GET,'page',1);
			$offset   = ($page_num - 1) * $per_page;
			
			$order_by = Arr::get($_GET,'order_by','name');
			$order_dir = Arr::get($_GET,'order_dir','ASC');
				
			$tovars = $tovars->order_by($order_by,$order_dir)
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
					'id'=>$category_id
				));
			
			
			$sort = ($count == 0) ? '' : View::factory('user/tovars/sort')
										->set('order_by',$order_by)
										->set('order_dir',$order_dir);
				
			$mebel = ORM::factory('category',1);
			$this->template->content = View::factory('user/tovars')
				->bind('pagination',$pagination)
				->bind('sort',$sort)
				->bind('tovars',$tovars)
				->bind('category_id',$category_id)
				->set('tree',$mebel->get_subtree());
				
    	} 
    }    
	
    public function action_index()
    {
	
		// Load the user information
    	$user = Auth::instance()->get_user();

		$this->template->h1 = 'Личный кабинет '.$user->username;
		$this->template->navibar = '';
		$this->template->navpills = '';
		
		if (Auth::instance()->logged_in('admin'))
        {
           	Request::current()->redirect('admin/index');
        }
		
		
			$this->template->content = View::factory('user/info')
			->bind('user', $user)
			->bind('count_tovars', $count_tovars)
			->bind('count_stocks', $count_stocks)
			->bind('count_shops', $count_shops)
			->set('active', $user->company->active);
			
			$count_tovars=ORM::factory('tovar')
			->where('user_id','=', $user->id)
			->count_all();
			
			$count_stocks=ORM::factory('stock')
			->where('user_id','=', $user->id)
			->count_all();
			
			$count_shops=ORM::factory('shop')
			->where('user_id','=', $user->id)
			->count_all();
    	
    }
    
    public function action_stocks()
    {
    	$this->template->h1 = 'Мои акции';
    	$this->template->toolbar = View::factory('user/stocks/toolbar');
		$this->template->navibar = '';
		$this->template->navpills = View::factory('user/navpills')->set('nav',$this->nav());
    	$this->template->navpills->nav['first']['Мои акции']['class'] = 'active';
    	$this->template->content = View::factory('user/stocks')
    	->bind('stocks',$stocks)
    	->bind('pagination',$pagination);
    	$per_page = 5;
    	$page_num = Arr::get($_GET,'page',1);
    	$offset   = ($page_num - 1) * $per_page;

    	$user=Auth::instance()->get_user();
    	
    	$count=ORM::factory('stock')
    	->where('user_id','=', $user->id)
    	->count_all();
    	
    	$stocks=ORM::factory('stock')
    	->where('user_id','=', $user->id)
    	->order_by('created_time','desc')
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
	
	public function action_shops()
    {
    	$this->template->h1 = 'Мои магазины';
    	$this->template->toolbar = View::factory('user/shops/toolbar');
		$this->template->navibar = '';
		$this->template->navpills = View::factory('user/navpills')->set('nav',$this->nav());
    	$this->template->navpills->nav['first']['Мои магазины']['class'] = 'active';
    	
		$user=Auth::instance()->get_user();
    	$count=ORM::factory('shop')
			->where('user_id','=', $user->id);
			
		$shops = clone $count;
		
		$count =$count->count_all();
		$per_page = Arr::get($_GET,'per_page',5);

		$page_num = Arr::get($_GET,'page',1);
		$offset   = ($page_num - 1) * $per_page;
		
		$order_by = Arr::get($_GET,'order_by','name');
		$order_dir = Arr::get($_GET,'order_dir','ASC');
		
		$shops = $shops->order_by($order_by,$order_dir)
			->offset($offset)
			->limit($per_page)
			->find_all();
		
		if (HTTP_Request::POST == $this->request->method()){
			if (isset($_POST['shop'])) {
				$optionArray = $_POST['shop'];
				for ($i=0; $i<count($optionArray); $i++) {
					$shop = ORM::factory('shop', $optionArray[$i]);
					if ($shop->loaded()){
						$shop->delete();
					}
				}
				$_POST = array();
				$this->request->redirect('/user/shops/');	
			}
		}

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
			
		$sort = View::factory('user/shops/sort')
			->set('order_by',$order_by)
			->set('order_dir',$order_dir);
		
		if ($count != 0) 
			$this->template->content = View::factory('user/shops')
			->bind('shops',$shops)
			->bind('sort',$sort)
			->bind('pagination',$pagination);
    }
	
	public function action_files(){
		$this->template->navibar = '';
		$this->template->navpills = View::factory('user/navpills')->set('nav',$this->nav());
    	$this->template->navpills->nav['first']['Мои товары']['class'] = 'active';
		$this->template->h1 = 'Мои товары';
		$this->template->content = View::factory('user/files/form')
            ->bind('errors', $errors)
			->bind('message', $message);
		if (HTTP_Request::POST == $this->request->method()){
			$file = ORM::factory('file')->values(Arr::merge($_FILES, $this->request->post()));
			try {
				$file = ORM::factory('file')->create_file();
				$file->save();
			}
			catch (ORM_Validation_Exception $e) {

                // Set failure message
                $message = 'Не удалось загрузить файл';
                 
                // Set errors using custom messages
                $errors = $e->errors('models');
            }
		}
	}
    
    public function action_create()
    {
        $this->template->content = View::factory('user/create')
            ->bind('errors', $errors)
            ->bind('message', $message);
        $this->template->h1 = 'Добавить пользователя';
             
        if (HTTP_Request::POST == $this->request->method())
        {          
            try {
         
                // Create the user using form values
                $user = ORM::factory('user')->create_user($this->request->post(), array(
                    'username',
                    'password',
                    'email'            
                ));
                 
                // Grant user login role
                $user->add('roles', ORM::factory('role', array('name' => 'login','name'=>'seller')));
                 
                // Reset values so form is not sticky
                $_POST = array();
                 
                // Set success message
                $message = "Пользователь <b>{$user->username}</b> добавлен.";
                 
            } catch (ORM_Validation_Exception $e) {
                 
                // Set failure message
                $message = 'Не удалось создать пользователя.';
                 
                // Set errors using custom messages
                $errors = $e->errors('models');
            }
        }
    }
    
	public function action_register()
    {
        $this->template->content = View::factory('user/register')
            ->bind('errors', $errors)
            ->bind('message', $message);
        $this->template->h1 = 'Регистрация';
             
        if (HTTP_Request::POST == $this->request->method())
        {          
			
            try {
         
                // Create the user using form values
                $user = ORM::factory('user')->create_user($this->request->post(), array(
                    'username',
                    'password',
                    'email',
                	'name',
                	'phone',            
                ));
                 
				$company = ORM::factory('company')->create_company(
					array(
						'user_id' => $user->id,
						'company_name' => $this->request->post('company_name')
					), 
					array(
					'user_id',
                    'company_name',           
                )); 
				 
				$company -> active = 1;
				$company -> save();	
				 
                // Grant user login role
                $user->add('roles', ORM::factory('role', array('name' => 'login')))
                	 ->add('roles', ORM::factory('role', array('name' => 'seller')));
                 
                // отправляем уведомление на почту
                $content = View::factory('email/register')
							->set('username', $this->request->post('username'))
							->set('password', $this->request->post('password'));
				
				//Email::send($user->email, 'noreply@mebelboom.com', 'Регистрация на сайте mebelboom.com', $content, true);
               
				$this->request->redirect('/user/'); 
               
				// Set success message
                //$message = "Пользователь <b>{$user->username}</b> добавлен.";
                 
            } catch (ORM_Validation_Exception $e) {
                 
                // Set failure message
                $message = 'Не удалось создать пользователя.';
                 
                // Set errors using custom messages
                $errors = $e->errors('models');
            }
        }
    }
     
    public function action_login()
    {	
		$this->template->h1 = 'Личный кабинет продавца';
		$this->template->navibar = '';
        $this->template->content = View::factory('user/login')
            ->bind('message', $message);
        
             
        if (HTTP_Request::POST == $this->request->method())
        {
            // Attempt to login user
            $remember = array_key_exists('remember', $this->request->post()) ? (bool) $this->request->post('remember') : FALSE;
            
            $user = Auth::instance()->login($this->request->post('username'), $this->request->post('password'), $remember);
             
            // If successful, redirect user
            if (Auth::instance()->logged_in('admin'))
            {
            		Request::current()->redirect('admin/index');
           	}
           	else if(Auth::instance()->logged_in('login'))
           	{
           			Request::current()->redirect('user/index');
            }
            else
            {
                $message = 'Неверное имя пользователя или пароль';
            }
        }
    }
     
	  public function action_loginza()
    {	
		$model = $this->request->param('r_model');
		$action = $this->request->param('r_action');
		$id = $this->request->param('r_id');
	
		$this->template->h1 = 'Авторизация через Loginza';
		
		if(Auth::instance()->logged_in())
		{
			$this->template->content = "Вы уже авторизованы.";
			return true;
		}
		
		$this->template->content = View::factory('user/loginza')
            ->bind('message', $message)
            ->set('domain', Kohana_URL::base(true))
			->set('model', $model)
			->set('action', $action)
			->set('id', $id);
        
        
		
		if(!$this->request->post('token')) return true;
		
		//отправляем запрос на получение данных пользователя
		$auth_data = file_get_contents('http://loginza.ru/api/authinfo?token='.$this->request->post('token'));
		$ad = json_decode($auth_data, true);
		
		if (isset($ad['error_type']))
		{
			$message = 'Ошибка получения данных';
		}
		else
		{
				//запрашиваем пользователя
				$user = ORM::factory('user');
					if (isset($ad['email']))
					{	
						$user->or_where_open()->where('email','=', $ad['email'])->or_where('identity','=',$ad['identity'])->or_where_close();
					}
					else
					{	
						$user->where('identity','=',$ad['identity']);
					}
					
					$user->find();
					
				//если пользователь существует, то авторизуем его 	
				if($user->loaded())
				{
					Kohana_Auth_File::instance()->force_login($user);
					
					if (Auth::instance()->logged_in('admin'))
					{
						Request::current()->redirect('admin/index');
					}
					elseif(Auth::instance()->logged_in('seller'))
					{
						Request::current()->redirect('user/index');
					}
					else
					{	
						Request::current()->redirect($model.'/'.$action.'/'.($id?$id:''));
					}
				}
				else // иначе создаем вновь
				{
					
					try {
						// Create the user using form values
						$user = ORM::factory('user', array('identity' => $ad['identity']));
						
						if (!$user->loaded())
						{	
							$config = Kohana::$config->load('loginza');
							$data['username'] = $data['email'] = '';
							foreach($config['username'] as $part_of_name)
								$data['username'] .= (empty($ad['name'][$part_of_name]) ? '' : (' '.$ad['name'][$part_of_name]));
				
							$data['username'] = trim($data['username']);
							
							if (!$data['username']) $data['username'] = (empty($ad['name']['full_name']) ? '' : (' '.$ad['name']['full_name']));
							
							if (!$data['username']||$data['username']=='')
							{
								//throw new Kohana_Exception('Username fields not set in config/loginza.php');
								
								$message = 'Недостаточно данных. Пожалуйста, введите информацию о себе в выбранном сервисе авторизации, либо используйте другой сервис.';
							}
							else
							{
								$data['password'] = 'loginza_autogenerated_password';
								
								$data['identity'] = $ad['identity'];
								
								$cfg_fields = $config['mapping_paths'];
								foreach($cfg_fields as $field)
								{	
									if (!empty($ad[$field]))
										$data[$field] = $ad[$field];
								}
								
								if (!$data['email']) $data['email'] = 'anonymous@anonymous.com';
								
								$user->values($data);
								$user->create();
								
								$user->add('roles', ORM::factory('role', array('name' => 'login')));
								
								/*$company = ORM::factory('company')->create_company(
									array(
										'user_id' => $user->id,
										'company_name' => trim($data['username']),
									), 
									array(
									'user_id',
									'company_name',           
								));*/ 
								
								//$company -> active = 1;
								//$company -> save();	
								
								Auth::instance()->force_login($user);
								
								Kohana_Auth_File::instance()->force_login($user);
								
								Request::current()->redirect($model.'/'.$action.'/'.($id?$id:''));
							}
						}
						else
						{
							Auth::instance()->force_login($user);
							
							Kohana_Auth_File::instance()->force_login($user);
						
							if (Auth::instance()->logged_in('admin'))
							{
								Request::current()->redirect('admin/index');
							}
							elseif(Auth::instance()->logged_in('seller'))
							{
								Request::current()->redirect('user/index');
							}
							else
							{	
								Request::current()->redirect($model.'/'.$action.'/'.($id?$id:''));
							}
							
						}
						
						
						 
					} catch (ORM_Validation_Exception $e) {
						 
						// Set failure message
						$message = 'Не удалось создать пользователя.';
						 
						// Set errors using custom messages
						$errors = $e->errors('models');
					}
				}
		}
		
    } 
	 
    public function action_logout()
    {
        // Log user out
        Auth::instance()->logout();
         
        // Redirect to login page
        Request::current()->redirect('/');
    }
    
	public function action_forget()
    {
	
	
		$this->template->content = View::factory('user/forget')
            ->bind('message', $message);
        $this->template->h1 = 'Восстановление пароля';
             
        if (HTTP_Request::POST == $this->request->method())
        {
            $user = ORM::factory('user')
			->where('email','=', $this->request->post('email'))->find();
			
			if($user->loaded())
			{	
				//генерируем случайную строку
				$model_user = new Model_User;
				$restore_code = $model_user->generatePassword(18);	
				
				//записываем полученную строку в базу для полученного пользователя
				$user->activate_code = $restore_code;
				$user->save();
				
				//отправляем запрос на восстановление пароля
				$content = View::factory('email/forget')
							->set('url',Kohana_URL::base(true))
							->set('restore_code', $restore_code) 
							->set('username', $user->username); 
				
				Email::send($user->email, 'noreply@mebelboom.com', 'Восстановление пароля на сайте mebelboom.com', $content, true);
				
				$this->template->content = 'На указанный адрес выслана ссылка для получения нового пароля';
			}
			else
			{
				$message = 'Пользователя с таким адресом не существует';
			}
        }
    }
	
	public function action_restore()
    {
         $this->template->content = View::factory('user/restore')
            ->bind('message', $message)
			->bind('username', $username)
			->bind('new_password', $new_password)
			->bind('notice', $notice);
        $this->template->h1 = 'Восстановление пароля';
         
		$restore_code = $this->request->param('id');	
        
		if($restore_code)
		{	
			//запрашиваем ползователя с указанным кодом
            $user = ORM::factory('user')
			->where('activate_code','=', $restore_code)->find();
			
			if($user->loaded())
			{	
				$auth = Auth::instance();
				$model_user = new Model_User;
				
				//генерируем новый пароль
				$new_password = $model_user->generatePassword(8); 
				
				//записываем пароль в базу (хеширование выполняется при записи)
				$user->password = $new_password;
					
				//удаляем код 
				$user->activate_code = '';
				$user->save();
				
				$username = $user->username;
				$notice = 'Пароль успешно изменен.';
				
				//отправляем новый пароль 
				$content =  View::factory('email/restore')
							->set('url', Kohana_URL::base(true))
							->set('username', $username)
							->set('new_password', $new_password);
				Email::send($user->email, 'noreply@mebelboom.com', 'Восстановление пароля на сайте mebelboom.com', $content, true);
				
			}
			else
			{
				$message = 'Неверный код активации';
			}
		}	
        else
		{
			$message = 'Не указан код активации';
		}
    }
    
	public function action_edit()
    {
		
    	$this->template->h1 = 'Личные данные';
    		
    	if(Auth::instance()->logged_in('seller'))
    	{
			$this->template->navibar = '';
			$this->template->navpills = View::factory('user/navpills')->set('nav',$this->nav());
	    	$this->template->navpills->nav['second']['Личные данные']['class'] = 'active';
    	}
    	else 
    	{
    		$this->template->navpills = '';
    	}	
    	
    	$this->template->content = View::factory('user/edit')
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
					$user = ORM::factory('user',$user->id)->edit_user($this->request->post(), array(
						'username',
						'password',
						'name',
						'phone',
						'post',						
					));
					 
					// Reset values so form is not sticky
					$_POST = array();
					 
					// Set success message
					$message = "Данные успешно отредактированы.";
					 
				} catch (ORM_Validation_Exception $e) {
					 
					// Set failure message
					$message = 'Не удалось отредактировать личные данные.';
					 
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
	
	public function action_del()
	{
		$id = $this->request->param('id');
		ORM::factory('user',$id)->delete();
		$this->request->redirect('/admin/company/');
	}
	
	public function action_feedback()
	{
		$this->template->h1 = 'Отправить сообщение менеджеру';
		
		$manager = DB::query(Database::SELECT,"SELECT users.* FROM users,roles,roles_users WHERE roles.name = 'admin' AND roles.id = roles_users.role_id AND users.id = roles_users.user_id")->execute()->as_array();
		
		$user = Auth::instance()->get_user();
		
		if($user)
		{	
			$this->template->content = View::factory('user/feedback/form')
											->set('manager',$manager[0])
											->bind('user',$user)
											->bind('values',$values)
											->bind('errors',$errors);
		
			
		
			// Create the user using form values
			$user = ORM::factory('user',$user->id);
		
			$values = array();
			$values['seller'] = $user->username;
			$values['email'] = $user->email;
			if (HTTP_Request::POST == $this->request->method())
			{
				try {
					
					$validation = $user->feedback_valid($this->request->post(), array(
							'theme',
							'message',         
					));
									
					if($validation){
						// отправляем уведомление на почту
						$content = View::factory('user/feedback/email')
											->set('values',$this->request->post());		
						Email::send($manager[0]['email'], 'noreply@mebelboom.com', 'Новое сообщение с mebelboom.com', $content, true);		   
					
						$this->request->redirect('/user/sent'); 
					}
					
				} catch (ORM_Validation_Exception $e) {			 
					$message = 'Не удалось отправить сообщение.';
								 
					$errors = $e->errors('models');
				}
			}	
		}
		else
		{
			$this->request->redirect('/user/login/');
		}
	}
	
 	public function action_mail()
 	{
 		$mailer = Email::connect();
		$message = Swift_Message::newInstance('Подтверждение регистрации', 'Спасибо, что зарегистрировались на tatmarket.ru', 'text/html', 'utf-8');
		$message->setTo('alex@rupromo.ru', 'Александр');
		$message->setFrom('noreply@tatmarket.ru');
		$mailer->send($message);
		$this->template->content = Debug::dump($message);
 	}
 	
 	public function action_favorites()
 	{
 		$this->template->h1 = 'Избранное';
		$this->template->navpills ='';
		$this->template->navibar = View::factory('page/navibar')->set('nav',Controller_Page::nav());
 		$content = View::factory('user/favorites');
		
 		if(Auth::instance()->logged_in('login'))
		{
			$content->bind('tovars',$tovars);
			$tovars = Auth::instance()->get_user()->favorites->find_all();
		}
		else
		{
			$content->bind('loginza',$loginza);
			$loginza = View::factory('user/loginza')
										->set('domain', Kohana_URL::base(true))
										->set('model', $this->request->controller())
										->set('action', $this->request->action())
										->set('id', $this->request->param('id', 0))
										->bind('message', $message);
		}
		$this->template->content = $content;
 	}
 	
 	public function action_remove_from_favorites()
 	{
 		$tovar = ORM::factory('tovar',$this->request->param('id'));
 		if($tovar->loaded())
 		{
 			$tovar->remove_from_favorites();
 		}
 		$this->request->redirect('/user/favorites/');
 	}
	
	public function action_clear_favorites()
 	{
 		DB::delete('favorites')
		->where('user_id','=',Auth::instance()->get_user()->id)
		->execute();
		
 		$this->request->redirect('/user/favorites/');
 	}
	
	public function action_sent()
	{
		$this->template->h1 = "Сообщение отправлено";
		$this->template->content = View::factory('user/feedback/sent');
	}
	
}        
    