<?php

namespace Nabble\SemaltBlocker;

class Updater
{

    public static $ttl = 604800;

    public static $updateUrl = 'https://raw.githubusercontent.com/nabble/semalt-blocker/master/domains/blocked';

    private static $blocklist = 'blocked';

    public static function update($force = false)
    {
        if (! defined('SEMALT_UNIT_TESTING') && ! self::isWritable()) {
            return;
        }
        if (! $force && ! self::isOutdated()) {
            return;
        }
        self::doUpdate();
    }

    public static function getNewDomainList()
    {
        if (function_exists('curl_init')) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => self::$updateUrl
            ]);
            $domains = curl_exec($curl);
            curl_close($curl);
        } else {
            $domains = @file_get_contents(self::$updateUrl);
        }
        return $domains;
    }

    public static function getBlocklistFilename()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . static::$blocklist;
    }

    private static function doUpdate()
    {
        $domains = self::getNewDomainList();
        if (trim($domains) !== '') {
            @file_put_contents(self::getBlocklistFilename(), $domains);
        }
    }

    private static function isWritable()
    {
        return is_writable(self::getBlocklistFilename());
    }

    private static function isOutdated()
    {
        return filemtime(self::getBlocklistFilename()) < (time() - self::$ttl);
    }
}
