<?php

class YandexDiskFilesListBuilder
{
    private static $fileNameIndex = 'dav::multistatus_dav::response_dav::propstat_dav::prop_dav::displayname_';

    public static function createFilesList($id)
    {
        $importYandexFiles = array();
        $yandexDisk = YandexDiskBuilder::build();
        $list = $yandexDisk->getFiles(YandexDiskConfig::FOLDER);
        $list = self::filterFilesByExtension($list);

        foreach ($list as $file) {
            $importYandexFile = ORM::factory('importYandexFile');
            $importYandexFile->name = $file['fileName'];
            $importYandexFile->import_id = $id;
            $importYandexFile->path = YandexDiskConfig::FOLDER;
            $importYandexFile->create();
            $importYandexFiles[] = $importYandexFile;
        }
        $yandexDisk->close();
        return $importYandexFiles;
    }

    private static function filterFilesByExtension($list)
    {
        foreach ($list as $key => $file) {
            $filename = $file['fileName'];
            $ext = end(explode('.', $filename));
            if ($ext !== 'ppt' && $ext !== 'pptx') {
                unset($list[$key]);
            }
        }
        return $list;

    }


}