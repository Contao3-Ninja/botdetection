<?php

namespace Nabble\SemaltBlocker;

class Blocker
{

    const SEPERATOR = ':';

    public static $explanation = "Access to this website has been blocked because your referral is set to %s. <a href='%s'>Read why</a>";

    private static $blocklist = 'blocked';

    private static $reason = 'Not blocking, no reason given';

    public static function protect($action = '')
    {
        if (! defined('SEMALT_UNIT_TESTING')) {
            Updater::update();
        }
        if (! self::isRefererOnBlocklist()) {
            return;
        }
        self::doBlock($action);
        if (! defined('SEMALT_UNIT_TESTING')) {
            exit();
        }
    }

    public static function blocked($verbose = false)
    {
        $blocked = self::isRefererOnBlocklist();
        if ($verbose === true) {
            return self::$reason;
        }
        return $blocked;
    }

    public static function explain()
    {
        return self::$reason;
    }

    public static function forbidden()
    {
        $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
        header($protocol . ' 403 Forbidden');
    }

    public static function getBlocklist()
    {
        return self::parseBlocklist(self::getBlocklistContents());
    }

    public static function getBlocklistFilename()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . static::$blocklist;
    }

    private static function doBlock($action = '')
    {
        if (! defined('SEMALT_UNIT_TESTING')) {
            self::cls();
        }
        self::blockAction($action);
        echo sprintf(self::$explanation, self::getHttpReferer(), 'https://www.google.com/#q=' . urlencode(preg_replace('/https?:\/\//', '', self::getHttpReferer()) . ' referral spam'));
    }

    private static function blockAction($action = '')
    {
        if (filter_var($action, FILTER_VALIDATE_URL)) {
            self::redirect($action);
        } else {
            self::forbidden();
            if (! empty($action)) {
                echo $action . '<br/>';
            }
        }
    }

    private static function cls()
    {
        while (ob_get_level()) {
            ob_end_clean();
        }
    }

    private static function redirect($url)
    {
        header('Location: ' . $url);
    }

    public static function isRefererOnBlocklist()
    {
        $referer = self::getHttpReferer();
        if ($referer === null) {
            self::$reason = 'Not blocking because referer header is not set or empty';
            return false;
        }
        return self::isUrlOnBlocklist($referer, 'referer');
    }

    public static function isUrlOnBlocklist($url, $entity = 'url')
    {
        $rootDomain = Domainparser::getRootDomain($url);
        if ($rootDomain === false) {
            self::$reason = "Not blocking because we couldn't parse root domain";
            return false;
        }
        $blocklist = self::getConcatenateBlocklist();
        if (substr_count($blocklist, self::SEPERATOR . $rootDomain . self::SEPERATOR)) {
            self::$reason = 'Blocking because ' . $entity . ' root domain (' . $rootDomain . ') is found on blocklist';
            return true;
        }
        $hostname = Domainparser::getHostname($url);
        if (substr_count($blocklist, self::SEPERATOR . $hostname . self::SEPERATOR)) {
            self::$reason = 'Blocking because ' . $entity . ' hostname (' . $hostname . ') is found on blocklist';
            return true;
        }
        $path = Domainparser::getPath($url);
        if (trim($path, '/')) {
            if (substr_count($blocklist, self::SEPERATOR . $rootDomain . $path . self::SEPERATOR)) {
                self::$reason = 'Blocking because ' . $entity . ' root domain/path (' . $rootDomain . $path . ') is found on blocklist';
                return true;
            }
            if (substr_count($blocklist, self::SEPERATOR . $hostname . $path . self::SEPERATOR)) {
                self::$reason = 'Blocking because ' . $entity . ' hostname/path (' . $hostname . $path . ') is found on blocklist';
                return true;
            }
        }
        self::$reason = 'Not blocking because ' . $entity . ' (' . $url . ') is not matched against blocklist';
        return false;
    }

    private static function getHttpReferer()
    {
        if (isset($_SERVER['HTTP_REFERER']) && ! empty($_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'];
        }
    }

    private static function getBlocklistContents()
    {
        $blocklistContent = file_get_contents(self::getBlocklistFilename());
        return $blocklistContent;
    }

    private static function getConcatenateBlocklist()
    {
        return self::concatenateBlocklist(self::getBlocklistContents());
    }

    private static function parseBlocklist($blocklistContent)
    {
        return array_map('trim', array_filter(explode(PHP_EOL, strtolower($blocklistContent))));
    }

    private static function concatenateBlocklist($blocklistContent)
    {
        return self::SEPERATOR . str_replace(PHP_EOL, self::SEPERATOR, strtolower($blocklistContent)) . self::SEPERATOR;
    }
}
