<?php defined('SYSPATH') or die('No direct script access.');
        
class Controller_Page extends Controller_Layout {
	
	public $secure_actions = array(
	'add'=>'admin',
	'edit'=>'admin',
	'del'=>'admin',
	);
	
	public function before()
	{
		array_push($this->scriptsArr, '/js/ckeditor/ckeditor.js','/js/page.js');
		parent::before();
	}
	
	public static function nav(){ 
		return array(
					
					'Каталог песен'=>array('href'=>'/song/'),
				'Молодежные'=>array('href'=>'/pesni/'),
				); 
	}
	
	public static function static_footer_menu() { 
		return array(
					'company'=>'Компании на портале',
				); 
	}
	
	public function action_index()
	{
		$this->template->title='Слова & Аккорды'; 
		$this->template->description='Песни и аккорды для песен церкви Слово веры в казани';
		$this->template->keywords='песня, аккорды, слова песни, тест песни, lyrics';
		
		$this->template->navibar = View::factory('page/navibar')->set('nav',$this->nav());
		
		$this->template->content = View::factory('page/home')
           // ->bind('stats',$stats_view)
            ->bind('lastsongs',$lastsongs);
		$this->template->rightBar= View::factory('page/rightbar/index')->bind('user',$userBar);
		
		if(!Auth::instance()->logged_in()){
			
			$userBar=View::factory('page/index/userlogin')->bind('error',$message);
			if (HTTP_Request::POST == $this->request->method())
			{
				// Attempt to login user
				$remember = array_key_exists('remember', $this->request->post()) ? (bool) $this->request->post('remember') : FALSE;
				
				$user = Auth::instance()->login($this->request->post('username'), $this->request->post('password'), $remember);
				
				
				// If successful, redirect user
				if (!Auth::instance()->logged_in('admin') and !Auth::instance()->logged_in('login'))
				{
					$message = 'Неверное имя пользователя или пароль';
				}
			}
			
			
		}
		if(Auth::instance()->logged_in()){
			$userBar=View::factory('page/index/user')->bind('user',$user);
			$user = Auth::instance()->get_user();
				
		}
		$lastsongs=View::factory('page/homesongs')
            ->bind('songs',$songs);
        $stats_view = View::factory('page/homestats')
            ->bind('tovars_count',$tovars_count)->bind('shops_count',$shops_count);


		$songs = ORM::factory('song')
				->where('active','=', 1)
                ->offset(0)
				->limit(5)
				->order_by('created_time','desc')
				->find_all();	
	}
	
	public function action_view()
	{
		$id = $this->request->param('id');
		$page = ORM::factory('page',$id);
		if($page->loaded())
		{
			$this->template->h1 = $page->name;
			$this->template->content = $page->content;
			
			if(Auth::instance()->logged_in('admin'))
			{
				$this->template->toolbar = View::factory('page/toolbar')->set('id',$id);
			}
		}
		else
		{
		}
	}
	
	public function action_byalt()
	{
		$alt_name = $this->request->param('alt_name');
		$page = ORM::factory('page')->where('alt_name', '=' , $alt_name)->find();
		
		$add_content = '';
		
		if($page->loaded())
		{
			if($alt_name=='about') 
			{
				$add_content = View::factory('page/about/form')
										->bind('captcha',$captcha)
										->bind('captcha_error',$captcha_error)
										->bind('message',$message)
										->bind('errors',$errors);
				$captcha = Captcha::instance();
				
				if (HTTP_Request::POST == $this->request->method())
				{	
					if(!Captcha::valid($this->request->post('captcha'))) $captcha_error['captcha'] = "Код введен неверно.";
					
					try {
						$validation = $page->feedback_valid($this->request->post(), array(
								'name',
								'phone',
								'email',
								'message',         
						));
						
						$user = DB::query(Database::SELECT,"SELECT users.* FROM users,roles,roles_users WHERE roles.name = 'admin' AND roles.id = roles_users.role_id AND users.id = roles_users.user_id")->execute()->as_array();				
						
						
						if($validation && Captcha::valid($this->request->post('captcha'))){
								 // отправляем уведомление на почту
							$content = View::factory('email/page/about/email')
										->set('values',$this->request->post());
								
							Email::send($user[0]['email'], 'noreply@mebelboom.com', 'Новое сообщение с mebelboom.com', $content, true);
							   
							$this->request->redirect('/page/sent'); 
						}
										
					} catch (ORM_Validation_Exception $e) {
							 
						$message = 'Не удалось отправить сообщение.';
							 
						$errors = $e->errors('models');
					}
				}			
			}
			
			$this->template->h1 = $page->name;
			$this->template->content = $page->content.$add_content;
			
			if(Auth::instance()->logged_in('admin'))
			{
				$this->template->toolbar = View::factory('page/toolbar')->set('id',$page->id);
			}
		}
		else
		{
			throw new HTTP_Exception_404();
		}
	}
	
	public function  action_add()
	{
		$view = View::factory('page/add')
            ->bind('errors', $errors)
            ->bind('message', $message);
        
		$this->template->navibar = View::factory('admin/navibar')->set('nav',Controller_Admin::nav());
		
		$this->template->h1 = 'Добавить страницу контента';
		$this->template->navibar->nav['Контент']['class'] = 'active';  
		$this->template->content = $view;
             
        if (HTTP_Request::POST == $this->request->method())
        {          
            try {
                $page = ORM::factory('page')
                ->values($this->request->post(), array(
								                    'name',
								                    'content',
                									'alt_name',
								                ))
                ->save();
                 
                $_POST = array();
                 
				//$this->request->redirect('/page/view/'.$page->id);
				$this->request->redirect('/admin/content/');
                
            } catch (ORM_Validation_Exception $e) {
                 
                $message = 'Не удалось создать страницу.';
                 
                $errors = $e->errors('models');
            }
        }
	}
	
	public function  action_edit()
	{
		$id = $this->request->param('id');
		$view = View::factory('page/add')
            ->bind('errors', $errors)
            ->bind('message', $message)
            ->bind('values', $values);
        
		$this->template->navibar = View::factory('admin/navibar')->set('nav',Controller_Admin::nav());
		$this->template->navibar->nav['Контент']['class'] = 'active';
		
		$this->template->h1 = 'Редактировать страницу контента';
		$this->template->content = $view;
        $page = ORM::factory('page',$id);
             
        if (HTTP_Request::POST == $this->request->method())
        {          
            try {
                $page->values($this->request->post(), array(
								                    'name',
								                    'content',
                									'alt_name',
								                ))
                ->save();
                 
                $_POST = array();
                 
				//$this->request->redirect('/page/view/'.$page->id);
				$this->request->redirect('/admin/content/');
                
            } catch (ORM_Validation_Exception $e) {
                 
                $message = 'Не удалось создать страницу.';
                 
                $errors = $e->errors('models');
            }
        }
        else
        {
        	$values = $page->as_array();
        }
		
	}
	
	public function action_del()
	{
		$id = $this->request->param('id');
		ORM::factory('page',$id)->delete();
		$this->request->redirect('/admin/content/');
	}
	
	public function action_sent()
	{
		$this->template->h1 = "Сообщение отправлено";
		$this->template->content = View::factory('page/sent');
	}
	
}    