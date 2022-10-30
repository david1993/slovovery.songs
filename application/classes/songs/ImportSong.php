<?php

class ImportSong
{
    public function __construct()
    {
        $this->ppt = new ppt();
    }

    public function import(array $list)
    {
        foreach ($list as $key => $file) {
            $fileName = $file ['fileName'];
            if (in_array($fileName, array('шаблон.ppt', '111.ppt'))) {
                continue;
            }
            $existingSong = ORM::factory('song')->where('hash', '=', $file ['hash'])->find_all()->as_array();
            echo $fileName;
            if (count($existingSong) === 1) {
                $song = $existingSong [0];
                echo ' <br/>песня не нуждается в обновлении';
                $song->setParamUpdated(1);
                $song->status_id = Model_Song::STATUS_CHECHED;
            } else {
                $this->importNewSongs($file);
            }
            echo '<br/>';
        }
    }

    private function importNewSongs($newSong)
    {
        echo $newSong['fileName'] . "<br/>";
        //добавляем песню
        $song = ORM::factory('song');
        $song->name = $song->getH1FromFileName($newSong['fileName']);
        $song->name_can_be_modified = 1;
        $song->creation_date = $newSong['creationDate'];
        $song->edit_date = $newSong['lastModified'];
        $song->hash = $newSong['hash'];
        $song->file = $newSong['fileName'];
        $song->updated = 1;
        $song->status_id = Model_Song::STATUS_MAYBEDUBLICATE;
        $song->active = false;
        $song->create();

        //Добавляем слайды
        foreach ($this->getTextFromFile($newSong['path']) as $slideNo => $slideText) {
            $slide = ORM::factory('slide');
            $slide->id_slide = $slideNo;
            $slide->text = $slideText;
            $slide->id_song = $song->id;
            $slide->active = 1;
            $slide->create();
        }

    }


    private function getTextFromFile($filename)
    {
        $ppt = $this->ppt;
        $ppt->read($filename);
        return $ppt->parse();
    }
}
