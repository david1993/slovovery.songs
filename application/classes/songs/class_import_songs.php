<?php

class import_songs
{
    /** @var  webdav_client */
    public $wdc;
    private $folder1;
    private $folder2;
    private $root;

    public function init($folder1, $folder2, $root)
    {
        error_reporting(0);
        $this->folder1 = $folder1;
        $this->folder2 = $folder2;
        $this->root = $root;
        $this->setWdc();
        $this->ppt = new ppt();
    }

    public function setWdc()
    {
        $wdc = $this->wdc;

        if (!class_exists('webdav_client')) {
            require('class_webdav_client.php');
        }
        $wdc = new webdav_client ();
        $wdc->set_debug(true);
        $wdc->set_server('ssl://webdav.yandex.ru');
        $wdc->set_site('webdav.yandex.ru');
        $wdc->set_port(443);
        $wdc->set_user('songs.slovovery');
        $wdc->set_pass('limons');
        // use HTTP/1.1
        $wdc->set_protocol(1);
        // enable debugging
        $wdc->set_debug(false);

        if (!$wdc->open()) {
            print 'Error: could not open server connection <br /> \r\n';
            exit ();
        }

        // check if server supports webdav rfc 2518
        if (!$wdc->check_webdav()) {
            print 'Error: server does not support webdav or user/password may be wrong <br /> \r\n';
            exit ();
        }
        $this->wdc = @$wdc;
    }

    public function closeWdc()
    {
        $this->wdc->close();
    }

    public function clearDir($dir)
    {
        if (!$dir) {
            $dir = $this->root . $this->folder2;
        }
        if ($objs = glob($dir . "*")) {
            foreach ($objs as $obj) {
                //echo $obj . ':<br>';
                if (is_dir($obj)) {
                    $this->clearDir($obj);
                } else {
                    unlink($obj);
                }
            }
        }
        if (glob('/path/*')) {
            return false;
        } else {
            return true;
        }
    }

    public function getFiles($dir)
    {
        $return = array();
        if (!$dir) {
            $dir = $this->root . $this->folder2;
        }

        if ($objs = glob($dir . "*")) {
            foreach ($objs as $obj) {
                if (!is_dir($obj)) {
                    $return[] = $obj;

                }
            }
        }
        return $return;
    }

    public function setFolder($path)
    {
        $this->folder2 = $path;
    }

    public function importFiles($list)
    {
        $i = 0;
        foreach ($list as $item) {
            // $item=$list[36];
            // echo 'e<br>';
            // if($i>1){exit; break;}
            if (isset ($item ['resourcetype']) && $item ['resourcetype'] == 'collection') {
                echo 'cont<br>\r\n';
                continue;
            }

            $name = $item ['dav::multistatus_dav::response_dav::propstat_dav::prop_dav::displayname_'];
            $href = $this->folder1 . $name;

            // echo $href . ' ' . $name;
            $tName = $name; // str_replace(' ', '&nbsp;', $name);
            $href2 = $this->root . $this->folder2 . $tName;
            // echo $href2.' gf';
            $rt = $this->getExtension($name);
            if ($rt == 'ppt' || $rt == 'pptx') {

                if ($this->wdc->get_file($href, $href2)) {
                    echo " returned true <br />\r\n";
                    $i++;
                    echo $i . '<br>\r\n'; // break;
                } else {
                    echo " returned false <br />\r\n";
                }
            }
        }
    }

    public function importFile($name)
    {
        //print_r($item);
        //$name = $item ['dav::multistatus_dav::response_dav::propstat_dav::prop_dav::displayname_'];
        //print_r($name);exit;
        //print_r($name);exit;
        $href = $this->folder1 . $name;
        $tName = $name; // str_replace(' ', '&nbsp;', $name);
        $href2 = $this->root . $this->folder2 . $tName;

        if ($this->wdc) {
            $this->wdc->close();
            $this->init($this->folder1, $this->folder2, $this->root);
        }
        if ($this->wdc->get_file($href, $href2)) {
            return $href2;
        } else {
            return false;
        }


    }

    public function checkList(&$list)
    {
        foreach ($list as $key => $item) {
            if (isset ($item ['resourcetype']) && $item ['resourcetype'] == 'collection') {
                unset($list[$key]);
                continue;
            }

            $name = $item ['dav::multistatus_dav::response_dav::propstat_dav::prop_dav::displayname_'];
            $rt = $this->getExtension($name);
            if ($rt != 'ppt' && $rt != 'pptx') {
                unset($list[$key]);
            }
        }
    }


    public function getTextFromFile($filename)
    {
        //ppt pptx
        $ppt = $this->ppt;
        $ppt->read($filename);
        return $ppt->parse();
    }

    function getExtension($filename)
    {
        return;
    }
}

?>