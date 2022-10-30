<?php

class YandexDisk
{
    private static $fileNameIndex = 's';
    /** @var  webdav_client */
    private $webDavClient;
    private $userName;
    private $password;

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getFiles($dir)
    {
        $files = $this->webDavClient->ls($dir);
        $files = self::filterOnlyFiles($files);
        return self::getFormattedFiles($files);
    }

    public function getFile($path, $localPath)
    {
        $this->webDavClient->get_file($path, $localPath);
    }

    public function start()
    {
        $this->webDavClient = new webdav_client();
        $this->webDavClient->set_server('ssl://webdav.yandex.ru');
        $this->webDavClient->set_site('webdav.yandex.ru');
        $this->webDavClient->set_port(443);
        $this->webDavClient->set_user($this->userName);
        $this->webDavClient->set_pass($this->password);
        $this->webDavClient->set_protocol(1);
        $this->webDavClient->set_debug(false);
        if (!$this->webDavClient->open()) {
        }
        if (!$this->webDavClient->check_webdav()) {
        }
    }

    public function close()
    {
        $this->webDavClient->close();
    }

    private static function filterOnlyFiles($list)
    {
        foreach ((array)$list as $key => $item) {
            if (isset ($item['resourcetype']) && $item['resourcetype'] === 'collection') {
                unset($list[$key]);
                continue;
            }
        }
        return $list;
    }

    private static function getFormattedFiles(array $files)
    {
        $array = array();
        foreach ($files as $file) {
            $array[] = self::getFileInfo($file);
        }
        return $array;
    }

    private static function getFileInfo(array $file)
    {
        return array(
            'fileName' => $file[self::$fileNameIndex],
        );
    }
}
