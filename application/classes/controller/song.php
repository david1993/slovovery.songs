<?php

defined('SYSPATH') or die ('No direct script access.');

class Controller_Song extends Controller_Layout
{
    public $secure_actions = array(
        'add' => array(
            'login'
        )
    );

    public function action_print()
    {
        $filterFields = ORM::factory('song')->getFilterFields();
        $arr = $_GET;

        foreach ($filterFields as $name => $f) {
            $value = isset($_SESSION[$name]) ? $_SESSION[$name] : '';

            if (isset($arr[$name])) {
                $newVal = $arr[$name];
                $_SESSION[$name] = $newVal;
                $value = $newVal;
            } else {
                if ($value == '') {
                    $value = $f['default'];
                    $_SESSION[$name] = $f['default'];
                }
            }
            $filterFields[$name]['value'] = $value;
        }
        $this->template->title = 'Каталог песен - Слова & Аккорды';
        $this->template->h1 = 'Печать песен';
        $this->template->description = 'Каталог христианских песен церкви Слово веры в казани';
        $this->template->keywords = 'Христинские песни, христианские гимны, презентации христианских песен, аккорды к песням, слова песни';

        // $this->template->status = View::factory('stock/rsslink');
        $this->template->navibar = View::factory('page/navibar')->set('nav', Controller_Page::nav());
        $this->template->navibar->nav ['Каталог песен'] ['class'] = 'active';

        $this->template->content = View::factory('song/print')->bind('songs', $songs);

        $per_page = Arr::get($_GET, 'per_page', 400);
        $page_num = Arr::get($_GET, 'page', 1);
        $offset = ($page_num - 1) * $per_page;

        $count = ORM::factory('song')->where('song.active', '=', 1)->count_all();

        $songs = ORM::factory('song')
            ->offset($offset)
            ->limit($per_page)
            ->distinct(true)
            ->order_by('song.' . $filterFields['sortfield']['value'], $filterFields['sorttype']['value']);

        if ($filterFields['accords']['value'] == 1) {
            $songs->join('accords')
                ->on('song.id', '=', 'accords.id_song')->group_by('song.id');
        }

        $songs = $songs->where('song.active', '=', '1')->find_all()->as_array();
    }

    public function action_index()
    {
        $filterFields = ORM::factory('song')->getFilterFields();
        $arr = $_GET;

        foreach ($filterFields as $name => $f) {
            $value = isset($_SESSION[$name]) ? $_SESSION[$name] : '';

            if (isset($arr[$name])) {
                $newVal = $arr[$name];
                $_SESSION[$name] = $newVal;
                $value = $newVal;
            } else {
                if ($value == '') {
                    $value = $f['default'];
                    $_SESSION[$name] = $f['default'];
                }
            }
            $filterFields[$name]['value'] = $value;
        }
        $this->template->title = 'Каталог песен - Слова & Аккорды';
        $this->template->h1 = 'Каталог песен';
        $this->template->description = 'Каталог христианских песен церкви Слово веры в казани';
        $this->template->keywords = 'Христинские песни, христианские гимны, презентации христианских песен, аккорды к песням, слова песни';
        $this->template->navibar = View::factory('page/navibar')->set('nav', Controller_Page::nav());
        $this->template->navibar->nav ['Каталог песен'] ['class'] = 'active';
        $this->template->rightBar = View::factory('song/rightbar/list')
            ->bind('yakors', $yakors)
            ->bind('filterFields', $filterFields);
        $this->template->content = View::factory('song/list')->bind('songs', $songs)->bind('pagination', $pagination);

        $per_page = Arr::get($_GET, 'per_page', 400);
        $page_num = Arr::get($_GET, 'page', 1);
        $offset = ($page_num - 1) * $per_page;

        $count = ORM::factory('song')->where('song.active', '=', 1)->count_all();

        $songs = ORM::factory('song')
            ->offset($offset)
            ->limit($per_page)
            ->distinct(true)
            ->order_by('song.' . $filterFields['sortfield']['value'], $filterFields['sorttype']['value']);

        if ($filterFields['accords']['value'] == 1) {
            $songs
                ->join('accords')
                ->on('song.id', '=', 'accords.id_song')->group_by('song.id')//->where('accords.active','=','1');
            ;
        }

        $songs = $songs->where('song.active', '=', '1')->find_all();

        $songAllList = ORM::factory('song')
            ->where('active', '=', 1)
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
    }

    public function action_view()
    {
        $id = $this->request->param('id');
        $song = ORM::factory('song', $id);

        $this->template->navibar = View::factory('page/navibar')->set('nav', Controller_Page::nav());
        $this->template->navibar->nav ['Каталог песен'] ['class'] = 'active';

        if ($song->loaded() and ($song->published() or Auth::instance()->logged_in('admin'))) {
            $newId = (int)json_decode(file_get_contents('http://slovovery.ru/24_7/song/redirect_to/?id=' . $song->id), true);
            $newSongUrl = 'http://slovovery.ru/24_7/song/' . $newId . '/';
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'http://slovovery.ru/') === 0) {
                header('Location: ' . $newSongUrl);
                exit;
            }

            $slides = $song->slides->where('active', '=', '1')->find_all();
            $accords = $song->accords->where('active', '=',
                '1')->order_by('publish_time')->order_by('id_user')->find_all();

            $firstSlide = $slides->as_array();
            if (isset($firstSlide[0])) {
                $firstSlide = $firstSlide[0]->text;
                $firstSlide = str_replace('<br/>', '', $firstSlide);
                $firstSlide = str_replace("\n", ' ', $firstSlide);
                $this->template->description = $firstSlide;
            }
            $this->template->keywords = "презентация песни $song->name, аккорды $song->name, слова $song->name, текст песни $song->name, lyrics $song->name";

            $this->template->breadcrumbs = View::factory('breadcrumbs')->set('items', array(
                array(
                    'name' => 'Каталог песен',
                    'href' => '/song/'
                )
            ));
            $this->template->h1 = $song->name;
            $this->template->title = $song->name . " - Слова & Аккорды";
            $this->template->rightBar = View::factory('song/rightbar/view')->bind('song', $song);
            $this->template->content = View::factory('song/view')->bind('song', $song)->bind('slides',
                $slides)->bind('accords', $accords)->bind('newSongUrl', $newSongUrl);

        } else {
            $this->template->h1 = 'Песня не найдена ):';
            $this->template->content = "Песня вероятно удалена<br/>Вы можете <a href='/song/'>найти песню в каталоге</a>";
        }
    }

    public function action_deleteNotMatched()
    {
        $helper = new \Helper\SongsNameMatchingProvider();
        foreach ($helper->getNotMatchedSongs() as $song) {
            $song->delete();
        }

        $this->request->redirect('/song/check_import');
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
            ->order_by('name')
            ->find_all();
        $notUpdated = ORM::factory('song')
            ->where('updated', '=', 0)
            ->order_by('name')
            ->find_all();
    }

    public function action_send_to_check()
    {
        if (!Auth::instance()->logged_in('admin')) {

            $this->request->redirect($this->request->referrer());

            return;
        }
        $id = $this->request->param('id');
        $song = ORM::factory('song', $id);
        $song->active = 0;
        $song->status_id = Model_Song::STATUS_MAYBEDUBLICATE;
        $song->save();
        $this->request->redirect('/song/check_import');
    }

    public function action_send_to_check2()
    {

        if (!Auth::instance()->logged_in('admin')) {

            $this->request->redirect($this->request->referrer());

            return;
        }
        $id = $this->request->param('id');
        $song = ORM::factory('song', $id);
        $song->updated = 0;
        $song->save();
        $this->request->redirect('/song/check_import');
    }


    public function action_push_song()
    {
        if (isset($_REQUEST['songOld']) and isset($_REQUEST['songNew'])) {
            $songOldId = $_REQUEST['songOld'];
            $songNewId = $_REQUEST['songNew'];
            $songNew = ORM::factory('song', $songNewId);

            if ($songOldId == 'new') {
                $songNew->active = 1;
                $songNew->save();
            } else {
                $songOld = ORM::factory('song', $songOldId);
                $helper = new \Helper\SongsMatchingHelper();
                $helper->matchSong($songOld, $songNew);
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

    public function action_setAllUpdated()
    {
        if (Auth::instance()->logged_in('admin')) {
            $notUpdated = ORM::factory('song')
                ->where('updated', '=', 0)
                ->find_all()->as_array();
            foreach ($notUpdated as $song) {
                $song->updated = 1;
                $song->save();
            }
        }


        $this->request->redirect($this->request->referrer());


    }

    public function action_delete()
    {

        $id = $this->request->param('id');
        if (Auth::instance()->logged_in('admin')) {
            $song = ORM::factory('song', $id);
            $slidesOld = $song->slides->find_all()->as_array();
            foreach ($slidesOld as $slideOld) {
                ORM::factory('slide', $slideOld->id)->delete();
            }
            $song->delete();

            $this->request->redirect(isset($_REQUEST['r']) ? $_REQUEST['r'] : '/song');

            return;
        }


        $this->request->redirect('/song/view/' . $id);

    }

    public function action_import()
    {
        require APPPATH . 'classes/songs/cfb.php';
        require APPPATH . 'classes/songs/ppt.php';
        if (!Auth::instance()->logged_in('admin')) {
            echo 'You are not admin';

            return;
        }
        $countNoUpdated = ORM::factory('song')->where('updated', '=', '0')->find_all()->count();
        if ($countNoUpdated) {
            $error = 'cant import because have NotUpdated';
            echo $error;
        } else {
            $songs = ORM::factory('song')->find_all()->as_array();
            foreach ($songs as $song) {
                $song->setParamUpdated(0);
            }
            $importer = new ImportSong();
            $filesProvider = new FileSystemSongProvider();
            $importer->import($filesProvider->getSongs());
        }
        $matchingHelper = new \Helper\SongsMatchingHelper();
        $matchingHelper->matchAllSongs();
        echo 'done';
        exit;

        // старый код по скачивают с яндекса
        $root = "./";
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
        $import_song->closeWdc();
    }
}
