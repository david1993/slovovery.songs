<?php

class FileSystemSongProvider
{
    public function __construct()
    {
        $this->dir = 'tmp/songs/';
    }

    public function getSongs()
    {
        $list = array();
        foreach (scandir($this->dir) as $a) {
            $path = $this->dir . $a;
            if(is_dir($path)){
                continue;
            }
            $file_parts = pathinfo($path);
            if ($file_parts['extension'] !== 'ppt') {
                continue;
            }
            $list[] = [
                'path' => $path,
                'fileName' => $a,
                'hash' => md5_file($path),
                'creationDate' => date('c', filectime($path)),
                'lastModified' => date('r', filemtime($path)),
            ];
        }
        return $list;
    }

}