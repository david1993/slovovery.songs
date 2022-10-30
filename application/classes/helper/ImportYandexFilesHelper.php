<?php

class ImportYandexFilesHelper
{
    public static $timeLimit = 60;

    public static function import()
    {
        $startTime = time();
        while ($startTime + self::$timeLimit > time()) {
            $params = JobService::getJob('getYandexFile');
            if ($params) {
                $yandexFile = ORM::factory('importYandexFile')->find($params['id']);
                $path = $yandexFile->path . $yandexFile->name;


            } else {
                sleep(1);
            }
        }
    }

    public function getFile($path)
    {
        $disk = YandexDiskBuilder::build();

        $disk->getFile($path, $localPath);
        // echo $href . ' ' . $name;
        $tName = $name; // str_replace(' ', '&nbsp;', $name);
        $href2 = $this->root . $this->folder2 . $tName;
        // echo $href2.' gf';
        $rt = $this->getExtension($name);
        if ($rt == 'ppt' || $rt == 'pptx') {

            if ($this->wdc->get_file($path, $href2, $i)) {
                echo " returned true <br />\r\n";
                $i++;
                echo $i . '<br>\r\n'; // break;
            } else {
                echo " returned false <br />\r\n";
            }
        }
    }
}