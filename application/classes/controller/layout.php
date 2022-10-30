<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Layout extends Controller_Template
{

	public $auth_required = false;

	public $secure_actions = false;

	public $user_id = false;

	public $scriptsArr = Array(
		'http://yandex.st/jquery/1.8.2/jquery.min.js',
		'/js/jquery/jquery-ui-1.9.1.custom.min.js',
		'/js/calendar/ui.datepicker-ru.js',
		'/js/bootstrap.min.js',
		'http://maps.google.com/maps/api/js?sensor=false',
		'/js/main.js?v=1',
		'//loginza.ru/js/widget.js',
		'/js/markermanager.js',
	);

	public function before()
	{
		parent::before();

		$action = $this->request->action();
		$controller = $this->request->controller();

		if ((Auth::instance()->logged_in('seller') && ($action == 'edit' || $action == 'add')) || $controller == 'service') {
			$this->template = View::factory('user');
		}

		if (Auth::instance()->logged_in('admin') && ($action == 'edit' || $action == 'add')) {
			$this->template = View::factory('admin');
		}

		$this->template->controller = $this->request->controller();
		$this->template->action = $this->request->action();

		$this->template->title = 'Слова & Аккорды';
		$this->template->h1 = '';
		$this->template->status = '';
		$this->template->navpills = '';
		$this->template->breadcrumbs = '';
		$this->template->toolbar = '';
		$this->template->content = '';
		$this->template->domain = Kohana_URL::base(true);
		$this->template->city = '';
		$this->template->loginza = '';
		$this->template->seller = '';
		$this->template->favorites = '';
		$this->template->search = View::factory('page/search');
		$this->template->scripts = View::factory('scripts')
			->bind('urls', $this->scriptsArr);

		$items = ORM::factory('page')->where('id', '<=', 3)->find_all()->as_array('alt_name', 'name');
		$static_items = Controller_Page::static_footer_menu();
		$this->template->footer_menu = View::factory('footer/menu')->set('items', $items)->set('static_items',
			$static_items);

		//Проверка прав пользователя
		$action_name = $this->request->action();
		if (($this->auth_required !== false && Auth::instance()->logged_in($this->auth_required) === false)
			|| (is_array($this->secure_actions) && array_key_exists($action_name, $this->secure_actions) &&
				Auth::instance()->logged_in($this->secure_actions[$action_name]) === false)
		) {
			if (Auth::instance()->logged_in()) {
				//Request::current()->redirect('user/index');
			} else {
				Request::current()->redirect('/user/login');
			}
		}

		//Панель пользователя
		$user = Auth::instance()->get_user();

		$this->template->favorites = View::factory('user/favorites/case')->bind('user', $user);

		if (!$user) {
			$this->template->loginza = View::factory('user/loginza')
				->set('domain', Kohana_URL::base(true))
				->set('model', $this->request->controller())
				->set('action', $this->request->action())
				->set('id', $this->request->param('id', 0))
				->bind('message', $message);
			$this->template->user = View::factory('user/signin');
		} else {
			$this->user_id = $user->id;
			$this->template->user = View::factory('user/short')->bind('user', $user);

		}
		if (Auth::instance()->logged_in('seller')) {
			$seller = Auth::instance()->get_user()->as_array();
			$manager = DB::query(Database::SELECT,
				"SELECT users.* FROM users,roles,roles_users WHERE roles.name = 'admin' AND roles.id = roles_users.role_id AND users.id = roles_users.user_id")->execute()->as_array();
			$this->template->seller = View::factory('user/seller')->set('seller', $seller)->set('manager', $manager[0]);
		}
	}
}
