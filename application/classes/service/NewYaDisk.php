<?php
/**
 * Зависимости:
 * - Sabre:  https://github.com/fruux/sabre-dav
 * - Carbon: https://github.com/briannesbitt/Carbon
 *
 * Использование:
 * $ya  = new \Ya\Disk(base64_encode(LOGIN . ':' . PASSWORD));
 * $wdc = $ya->getDisk();
 * print_r($wdc->getDirectory('/'));
 * print_r($wdc->getAvailableSpace());
 */

namespace Ya {

    use \Sabre\DAV\Client,
        \Ya\Disk\Item;

    class Disk
    {
        const SERVER_DISK = 'https://webdav.yandex.ru';
        const SERVER_OAUTH = 'http://oauth.yandex.ru';

        private $_client;

        public function __construct()
        {
            list($login, $password) = array('songs.slovovery', 'limons');
            $this->_client = new Client(array(
                'baseUri' => 'https://webdav.yandex.ru/',
                'userName' => $login,
                'password' => $password
            ));
          //  $this->_client->setVerifyPeer(false);
        }

        public function getAvailableSpace()
        {
            return $this->_client->propfind('collection', array(
                '{DAV:}quota-available-bytes',
                '{DAV:}quota-used-bytes',
            ));
        }

        public function getDirectory($dir = '/')
        {
            $response = $this->_client->request('PROPFIND', $dir, '', array(
                'Depth' => 1,
                'Content-Type' => 'application/xml'
            ));
            $result = $this->_client->parseMultiStatus($response['body']);

            $newResult = array();
            foreach ($result as $href => $statusList) {
                if ($href == $dir) {
                    continue;
                }
                $newResult[$href] = isset($statusList[200]) ? $statusList[200] : array();
            }
            return $this->fileSystemConvert($newResult);
        }

        protected function fileSystemConvert($fs)
        {
            $result = array();
            foreach ($fs as $name => $item) {
                $type = Item::getType($item['{DAV:}resourcetype']);
                unset($item['{DAV:}resourcetype']);
                $ns = __CLASS__ . '\\' . $type;
                $result[] = new $ns($name, $item);
            }
            return $result;
        }

        public function upload($name, $data)
        {
            $result = $this->_client->request('PUT', $name, $data, array(
                'Etag' => md5($data),
                'Sha256' => hash('sha256', $data),
                'Content-Length' => strlen($data)
            ));
        }
    }
}

namespace Ya\Disk {

    use \Sabre\DAV\Property\ResourceType,
        \Carbon\Carbon;

    class Item
    {
        const DAV_DIRECTORY = '{DAV:}collection';
        const DAV_CREATE_DATE = '{DAV:}creationdate';
        const DAV_MODIFIED_DATE = '{DAV:}getlastmodified';
        const DAV_SIZE = '{DAV:}getcontentlength';
        const DAV_NAME = '{DAV:}displayname';
        const DAV_HASH_MD5 = '{DAV:}getetag';
        const DAV_CONTENT_TYPE = '{DAV:}getcontenttype';
        const TYPE_DIRECTORY = 'Directory';
        const TYPE_FILE = 'File';
        protected $dir;
        private $_name;
        private $_created;
        private $_updated;
        private $_size;
        private $_type;
        private $_hash;

        public function __construct($dir, $data)
        {
            $this->dir = $dir;
            $this->_name = $this->_getName($data);
            $this->_created = $this->_getCreated($data);
            $this->_updated = $this->_getUpdated($data);
            $this->_size = $this->_getSize($data);
            $this->_type = $this->_getType($data);
            $this->_hash = $this->_getHash($data);
        }

        protected function _getName($data)
        {
            return $data[self::DAV_NAME];
        }

        protected function _getCreated($data)
        {
            return
                Carbon::createFromTimestamp(
                    strtotime($data[self::DAV_CREATE_DATE])
                );
        }

        protected function _getUpdated($data)
        {
            return
                Carbon::createFromTimestamp(
                    strtotime($data[self::DAV_MODIFIED_DATE])
                );
        }

        protected function _getHash($data)
        {
            return $data[self::DAV_HASH_MD5];
        }

        protected function _getType($data)
        {
            return $data[self::DAV_CONTENT_TYPE];
        }

        protected function _getSize($data)
        {
            return $data[self::DAV_SIZE];
        }

        public function toArray()
        {
            return array(
                'path' => $this->dir,
                'name' => $this->_name,
                'created' => $this->_created,
                'updated' => $this->_updated,
                'size' => $this->_type,
                'hash' => $this->_hash
            );
        }

        public static function getType(ResourceType $type)
        {
            $type = $type->resourceType;
            if (isset($type[0]) && $type[0] == self::DAV_DIRECTORY) {
                return self::TYPE_DIRECTORY;
            }
            return self::TYPE_FILE;
        }
    }


    class File extends Item
    {
    }

    class Directory extends Item
    {
        final protected function _getType($data)
        {
            return 'dir/collection';
        }

        final protected function _getHash($data)
        {
            return md5($this->dir);
        }
    }
}