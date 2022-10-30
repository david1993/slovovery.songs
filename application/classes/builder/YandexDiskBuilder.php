<?php

class YandexDiskBuilder
{
    private static $disk;

    public static function build()
    {
        if (!self::$disk) {
            self::$disk = new YandexDisk();
            self::$disk->setUserName(YandexDiskConfig::USER_NAME);
            self::$disk->setPassword(YandexDiskConfig::PASSWORD);
        }

        self::$disk->start();

        return self::$disk;
    }
}