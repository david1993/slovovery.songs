<?php
defined('SYSPATH') or die ('No direct script access.');

class Controller_Pesni extends Controller_Layout
{
	public $secure_actions = [
		'add' => [
			'login',
		]
	];

	public function action_index()
	{
		$filterFields = ORM::factory('pesni')->getFilterFields();
		$arr = $_GET;

		foreach ($filterFields as $name => $f) {
			$name0 = "pesni_" . $name;
			$value = isset($_SESSION[$name0]) ? $_SESSION[$name0] : '';
			if (isset($arr[$name])) {
				$newVal = $arr[$name];
				$_SESSION[$name0] = $newVal;
				$value = $newVal;
			} else {
				if ($value == '') {
					$value = $f['default'];
					$_SESSION[$name0] = $f['default'];
				}
			}
			$filterFields[$name]['value'] = $value;
		}
		$this->template->title = 'Каталог песен - Слова & Аккорды';
		$this->template->h1 = 'Молодежные песни';
		$this->template->description = 'Каталог христианских песен церкви Слово веры в казани';
		$this->template->keywords = 'Христинские песни, христианские гимны, презентации христианских песен, аккорды к песням, слова песни';

		$this->template->navibar = View::factory('page/navibar')->set('nav', Controller_Page::nav());
		$this->template->navibar->nav ['Молодежные'] ['class'] = 'active';
		$filter = View::factory('song/rightbar/list')->bind('yakors', $yakors)->bind('filterFields', $filterFields);

		$this->template->rightBar = View::factory('pesni/rightbar/index')->bind('user', $userBar)->bind('filter',
			$filter);

		$this->template->content = View::factory('pesni/list')->bind('songs', $songs)->bind('pagination', $pagination);

		$per_page = Arr::get($_GET, 'per_page', 300);
		$page_num = Arr::get($_GET, 'page', 1);
		$offset = ($page_num - 1) * $per_page;

		$count = ORM::factory('pesni')->count_all();


		$songs = ORM::factory('pesni')
			->offset($offset)
			->limit($per_page)
			->distinct(true)
			->order_by('pesni.' . $filterFields['sortfield']['value'], $filterFields['sorttype']['value']);

		if ($filterFields['accords']['value'] == 1) {
			$songs
				->where('accords', '!=', '');
		}

		$songs = $songs->find_all();

		$songAllList = ORM::factory('song')
			->order_by('name', 'asc')
			->find_all();
		$yakors = ORM::factory('song')->getYakors($songAllList);

		$pagination = Pagination::factory(array(
			'total_items' => $count,
			'items_per_page' => $per_page,
			'view' => 'pagination/withcount',
			'first_page_in_url' => true
		))->route_params(array(
			'controller' => $this->request->controller(),
			'action' => $this->request->action()
		));
		if (!Auth::instance()->logged_in()) {
			$userBar = View::factory('page/index/userlogin')->bind('error', $message);
			if (HTTP_Request::POST == $this->request->method()) {
				// Attempt to login user
				$remember = array_key_exists('remember',
					$this->request->post()) ? (bool)$this->request->post('remember') : false;

				$user = Auth::instance()->login($this->request->post('username'), $this->request->post('password'),
					$remember);


				// If successful, redirect user
				if (!Auth::instance()->logged_in('admin') and !Auth::instance()->logged_in('login')) {
					$message = 'Неверное имя пользователя или пароль';
				}
			}


		}
		if (Auth::instance()->logged_in()) {
			$userBar = View::factory('page/index/user')->bind('user', $user);
			$user = Auth::instance()->get_user();

		}
	}

	public function action_view()
	{
		$id = $this->request->param('id');
		$song = ORM::factory('pesni', $id);

		$this->template->navibar = View::factory('page/navibar')->set('nav', Controller_Page::nav());
		$this->template->navibar->nav ['Молодежные'] ['class'] = 'active';
		// if(($song->loaded() AND $song->published()) OR $song->user_id==$this->user_id OR Auth::instance()->logged_in('admin'))

		$this->template->rightBar = View::factory('page/rightbar/index')->bind('user', $userBar);
		if ($song->loaded()) {


			//$this->template->keywords="презентация песни $song->name, аккорды $song->name, слова $song->name, текст песни $song->name, lyrics $song->name";

			$this->template->breadcrumbs = View::factory('breadcrumbs')->set('items', array(
				array(
					'name' => 'Молодежные песни',
					'href' => '/pesni/'
				)
			));
			$this->template->h1 = $song->title;
			$this->template->title = $song->title . " - Слова & Аккорды";
			$this->template->content = View::factory('pesni/view')->bind('song', $song);


		} else {
			// $this->request->redirect('/');
			$this->template->h1 = 'Песня не найдена ):';
			$this->template->content = "Песня вероятно удалена<br/>Вы можете <a href='/song/'>найти песню в каталоге</a>";
			//throw new HTTP_Exception_404 ();
		}


		if (!Auth::instance()->logged_in()) {

			$userBar = View::factory('page/index/userlogin')->bind('error', $message);
			if (HTTP_Request::POST == $this->request->method()) {
				// Attempt to login user
				$remember = array_key_exists('remember',
					$this->request->post()) ? (bool)$this->request->post('remember') : false;

				$user = Auth::instance()->login($this->request->post('username'), $this->request->post('password'),
					$remember);


				// If successful, redirect user
				if (!Auth::instance()->logged_in('admin') and !Auth::instance()->logged_in('login')) {
					$message = 'Неверное имя пользователя или пароль';
				}
			}


		}
		if (Auth::instance()->logged_in()) {
			$userBar = View::factory('page/index/user')->bind('user', $user);
			$user = Auth::instance()->get_user();

		}
	}


	public function action_edit()
	{
		$id = $this->request->param('id');
		$song = ORM::factory('pesni', $id);
		$this->template->navibar = View::factory('page/navibar')->set('nav', Controller_Page::nav());
		$this->template->navibar->nav ['Молодежные'] ['class'] = 'active';
		$this->template->h1 = ($id == 'new') ? 'Добавить песню' : 'Изменить песню';
		$this->template->navpills = View::factory('user/navpills')->set('nav', Controller_Page::nav());
		$this->template->content = View::factory('pesni/edit')->bind('song', $song)->bind('values', $values);

		if ($song->loaded() || $id == 'new') {
			if (HTTP_Request::POST == $this->request->method()) {
				if ($id == 'new') {
					$song = ORM::factory('pesni');
					$song->create();
					$id = $song->id;
				}
				try {
					$song->text = trim($_POST['text'], ' ');
					$song->accords = trim($_POST['accords'], ' ');
					$song->title = trim($_POST['title'], ' ');


					if (isset($_FILES['filemp3']) && count($_FILES['filemp3']['name'])) {
						$song->save_file($id);
					}

					$song->save();
					$_POST = array();
					$song->reload();
					if ($this->request->param('id') == 'new') {
						$this->request->redirect('/pesni/edit/' . $id);
					}
				} catch (ORM_Validation_Exception $e) {
					$message = 'Не удалось создать aккорд.';
					$errors = $e->errors('models');
				}
			}
		}

		$values = array(

			'text' => $song->text,
			'title' => $song->title,
			'accords' => $song->accords

		);
	}

	public function action_check_import()
	{
		if (!Auth::instance()->logged_in('admin')) {
			return;
		}
		$this->template->navibar = View::factory('page/navibar')->set('nav', Controller_Page::nav());
		$this->template->navibar->nav ['Каталог песен'] ['class'] = 'active';
		$this->template->h1 = "Проверка импорта";
		$this->template->title = "Проверка импорта";

		$this->template->content = View::factory('song/check_import')
			->bind('imported', $imported)
			->bind('notUpdated', $notUpdated);
		$imported = ORM::factory('song')
			->where('active', '=', 0)
			->where('status_id', '=', Model_Song::STATUS_MAYBEDUBLICATE)
			->find_all();
		$notUpdated = ORM::factory('song')
			->where('updated', '=', 0)
			->find_all();
	}

	public function action_push_song()
	{
		if (HTTP_Request::POST == $this->request->method()) {
			if (isset($_POST['songOld']) and isset($_POST['songNew'])) {
				echo 'dfd';

				$songOldId = $_POST['songOld'];
				$songNewId = $_POST['songNew'];
				$songNew = ORM::factory('song', $songNewId);

				if ($songOldId == 'new') {
					$songNew->active = 1;
					$songNew->save();
				} else {
					$songOld = ORM::factory('song', $songOldId);
					$slidesOld = $songOld->slides->find_all()->as_array();
					foreach ($slidesOld as $slideOld) {
						ORM::factory('slide', $slideOld->id)->delete();
					}
					$songNew->created_time = $songOld->created_time;
					$songOld->delete();

					$slidesNew = $songNew->slides->find_all()->as_array();
					foreach ($slidesNew as $slideNew) {
						$slideNew->id_song = $songOldId;
						$slideNew->save();
					}
					$songNew->id = $songOldId;
					$songNew->active = 1;
					$songNew->status_id = Model_Song::STATUS_NEW;
					$songNew->save();
				}
			}
		}
		$this->request->redirect($this->request->referrer());
	}

	public function action_change_active()
	{
		if (Auth::instance()->logged_in('admin')) {
			$id = $this->request->param('id');
			$song = ORM::factory('song', $id);
			$active = $_POST['active'];
			if (in_array($active, array(1, 0))) {
				$song->active = $active;
				$song->save();
			}
		}
		$this->request->redirect($this->request->referrer());
	}

	public function action_import()
	{
		if (!Auth::instance()->logged_in('admin')) {
			return;
		}
		$root = "/var/www/david129/data/www/david.slovovery.ru/";
		if (!class_exists('import_songs')) {
			require("$root" . "songs/class_import_songs.php");
		}
		$folder1 = '/тексты песен/';
		$import_song = new import_songs ();
		$import_song->init($folder1, 'songs/files/', $root);

		$cleared = $import_song->clearDir($this->root . $this->folder2);
		if (!$cleared) {
			$error = 'didt cleared';
			echo $error;
			exit ();
		}
		$list = $import_song->wdc->ls($folder1);

		// фильтруем список. удаляем папки.
		$import_song->checkList($list);
		// $import_song->importFiles ($list);
		$countNoUpdated = ORM::factory('song')->where('updated', '=', '0')->find_all()->count();
		// ->as_array();
		if ($countNoUpdated) {
			$error = haveNoUpdated;
			echo $error;
			exit ();
		}
		//
		$songs = ORM::factory('song')->find_all()->as_array();
		$dbSongsCount = count($songs);
		$updated = 0;
		foreach ($songs as $song) {
			$song->setParamUpdated(0);
		}
		$newSongs = array();
		foreach ($list as $key => $file) {

			$path_parts = pathinfo($file);
			$fileName = $file ['dav::multistatus_dav::response_dav::propstat_dav::prop_dav::displayname_'];
			//$hrefO=$file[href];
			//$fileName=substr ($hrefO,strrpos ($hrefO,'/')+1);
			//echo $fileName;exit;
			$hash = $file ['dav::multistatus_dav::response_dav::propstat_dav::prop_dav::getetag_'];
			$creationdate = $file [creationdate];
			$lastmodified = $file [lastmodified];
			$existingSong = ORM::factory('song')->where('file', '=', $fileName)->find_all()->as_array();
			//print_r($fileName);exit;

			if ($song = $existingSong [0]) {
				if ($song->edit_date == $lastmodified) {
					echo 'песня не нуждается в обновлении<br/>';
					$song->setParamUpdated(1);
					$song->status_id = Model_Song::STATUS_CHECHED;
					$updated++;
					continue;
				} else {
					// обновляем!

					$href = $import_song->importFile($file);
					$slides = $import_song->getTextFromFile($href);

					//удаляем старые слайды
					$slidesOld = $song->slides->find_all()->as_array();
					foreach ($slidesOld as $slideOld) {
						ORM::factory('slide', $slideOld->id)->delete();
					}
					//добавляем новые
					foreach ($slides as $slideNo => $slideText) {


						$slide = ORM::factory('slide');
						$slide->id_slide = $slideNo;
						$slide->text = $slideText;
						$slide->id_song = $song->id;
						$slide->active = 1;
						$slide->create();

					}
					//меняем едит дата..
					//$data = array('active' => '1', 'edit_date' => $lastmodified);
					/*if($song->name_can_be_modified && $slides[0]){
						$song->name =$song->getH1FromSlide($slides[0]);
					}*/
					$newName = $song->getH1FromFileName($fileName);
					$song->name = $newName;
					$song->status_id = Model_Song::STATUS_EDITED;
					$song->set('edit_date', $lastmodified)->set('updated', 1)->save();
					$updated++;
				}
			} else {
				//print_r($hash.'!');print_r($creationdate.'!');print_r($lastmodified.'!');exit;
				$existingSong = ORM::factory('song')
					->where('hash', '=', $hash)
					->where('creation_date', '=', $creationdate)
					->where('edit_date', '=', $lastmodified)
					->find_all()->as_array();
				if ($existingSong) {
					if (count($existingSong) > 1) {
						$error = 'слишком много файлов для замены<br/>';
						echo $error;
						exit;
					}
					{
						echo 'поменялось только название файла';
						$song = $existingSong[0];
						$song->set('file', $fileName)->set('updated', 1)->save();
						$updated++;
					}

				} else {

					//echo 'оставляем для добавления, но не активируем<br/>';
					$newSongs[] = array(
						'filename' => $fileName,
						'hash' => $hash,
						'creation_date' => $creationdate,
						'lastmodified' => $lastmodified
					);
				}
				// не совпадение имени
				// проверяем хэш, дата создания,ласт модифиед,(размер файла) - при совпадении файл просто переименовали. обновляем название в бд
				// проверяем creationdate. можно проверять в конце среди необновленных песен в бд. совпадение - ФАЙЛ изменили и переименовали.

				// откладываем и потом проверяем файл среди не обновленных песен в базе. если не найдется то добавляем как новый

			}
		}
		echo 'добавляем новые песни</br>';
		$allUpdated = $updated == $dbSongsCount;
		//print_r($newSongs);exit;
		foreach ($newSongs as $newSong) {

			echo $newSong[filename] . "<br/>";
			$fileName = $newSong[filename];
			$href = $import_song->importFile($fileName);
			$slides = $import_song->getTextFromFile($href);
			//добавляем песню
			$song = ORM::factory('song');
			/*if($slides[0]){
				$h1 =$song->getH1FromSlide($slides[0]);
			}else{
				$h1='Без названия';
			}
			$song->name =$h1;*/
			$song->name = $song->getH1FromFileName($fileName);
			$song->name_can_be_modified = 1;
			$song->creation_date = $newSong[creation_date];
			$song->edit_date = $newSong[lastmodified];
			$song->hash = $newSong[hash];
			$song->file = $newSong[filename];
			$song->updated = 1;
			$song->status_id = $allUpdated ? Model_Song::STATUS_NEW : Model_Song::STATUS_MAYBEDUBLICATE;

			$song->active = $allUpdated;
			$song->create();


			//Добавляем слайды
			foreach ($slides as $slideNo => $slideText) {
				$slide = ORM::factory('slide');
				$slide->id_slide = $slideNo;
				$slide->text = $slideText;
				$slide->id_song = $song->id;
				$slide->active = 1;
				$slide->create();

			}
		}

		$import_song->closeWdc();

	}

	public function action_publish()
	{
		$id = $this->request->param('id');
		$category_id = $this->request->param('parent_id');
		$stock = ORM::factory('stock', $id);
		if ($stock->loaded()) {
			if (Auth::instance()->logged_in('admin')) {
				$stock->category_id = $category_id;
				$stock->publish()->save();
				$this->request->redirect('/admin/stock/');
			} elseif ($this->user_id == $stock->user_id) {
				$stock->moderate()->save();
				$this->request->redirect('/stock/added');
			}
		} else {
			$this->request->redirect($this->request->referrer());
		}
	}

	public function action_reject()
	{
		$id = $this->request->param('id');
		$stock = ORM::factory('stock', $id);
		if ($stock->loaded()) {
			if (Auth::instance()->logged_in('admin')) {
				$stock->reject($this->request->post('rejectreason'))->save();
			}
		}
		$this->request->redirect('/admin/stock/');
	}

	public function action_add()
	{
		$view = View::factory('stock/add')->bind('errors', $errors)->bind('message', $message)->bind('shops', $shops);

		$this->template->content = $view;
		$this->template->h1 = 'Добавить акцию';
		$this->template->navpills = View::factory('user/navpills')->set('nav', Controller_User::nav());
		$this->template->navpills->nav ['first'] ['Мои тексты песен'] ['class'] = 'active';
		$this->template->navibar = '';

		$user = Auth::instance()->get_user();
		$shops_arr = ORM::factory('shop')->where('user_id', '=', $user->id)->find_all()->as_array();
		$shops = array();

		foreach ($shops_arr as $shop) {
			$shops [$shop->id] = $shop->name . " " . ($shop->url ? $shop->url : $shop->address);
		}

		if (HTTP_Request::POST == $this->request->method()) {
			try {
				$stock = ORM::factory('stock')->create_stock(array_merge($this->request->post(), $_FILES), array(
					'name',
					'anons',
					'begin_time',
					'content',
					'url'
				));

				$stock->active = 1;
				$stock->save();

				if ($this->request->post('shop')) {
					foreach ($this->request->post('shop') as $shop_id) {
						$stock->add('shops', ORM::factory('shop', $shop_id));
					}
				}

				if ($stock->status_id == Model_Stock::STATUS_MODERATION) {
					$this->request->redirect('/stock/added');
				} else {
					$this->request->redirect('/user/stocks');
				}

				$_POST = array();
			} catch (ORM_Validation_Exception $e) {
				$message = 'Не удалось создать акцию.';
				$errors = $e->errors('models');
			}
		}
	}

	public function action_added()
	{
		$this->template->h1 = 'Акция отправлена на модерацию';
		$this->template->content = View::factory('stock/added');
	}

	public function action_delete()
	{
		$id = $this->request->param('id');
		$stock = ORM::factory('pesni', $id);
		if ($stock->loaded()) {
			if (Auth::instance()->logged_in('admin')) {
				$stock->delete();
				$this->request->redirect('/pesni');
			}
		}
	}
}