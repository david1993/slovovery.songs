<?php
defined('SYSPATH') or die ('No direct script access.');

class Controller_Import extends Controller_Layout
{
    public function action_index()
    {
        $this->template->h1 = 'Импорты';

        $imports = ORM::factory('import')->find_all()->as_array();

        $this->template->content = View::factory('import/index')->set('imports', $imports);
    }

    public function action_view()
    {
        $id = $this->request->param('id');
        $import = ORM::factory('import')->find($id);

        $songs = $import->songs->find_all()->as_array();
        if ($songs) {

            // $this->request->redirect("/import/view/$id/?stage=" . $import->stage);
        } else {
            $this->request->redirect("/import/upload_files/$id/");
        }
    }

    public function action_upload_files()
    {
        $id = $this->request->param('id');
        $import = ORM::factory('import')->find($id);
        $this->template->content = View::factory('import/import_files')->set('import', $import);
    }

    public function action_start()
    {
        $id = $this->request->param('id');
        $import = ORM::factory('import')->find($id);
        if ($import->is_files_imported) {
            $this->request->redirect("/import/view/$id/");
        }
        if (!$import->files->find_all()->as_array()) {
            $list = YandexDiskFilesListBuilder::createFilesList($id);
            foreach ($list as $file) {
                JobService::putJob('getYandexFile', ['id' => $file->id]);
            }
        }
        $this->template->content = View::factory('import/import_files_yandex')->set('import', $import);
    }


    public function action_import_yandex_files()
    {

        ImportYandexFilesHelper::import();
    }

}