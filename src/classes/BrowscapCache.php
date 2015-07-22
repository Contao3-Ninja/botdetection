<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2015 Leo Feyer
 *
 * BotDetection
 *
 * @copyright  Glen Langer 2007..2015 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetection
 * @license    LGPL
 * @filesource
 * @see        https://github.com/BugBuster1701/botdetection
 */

namespace BugBuster\BotDetection;

/**
 * Class BrowscapCache 
 *
 * @copyright  Glen Langer 2015 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetection
 */
class BrowscapCache
{
    // TODO - Insert your code here
    

    
    public static function generateBrowscapCache($force=false)//TODO Proxy Daten als Parameter
    {
        // set an own cache directory (otherwise the system temp directory is used)
        \Crossjoin\Browscap\Cache\File::setCacheDirectory(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cache');
    
        //Large sonst fehlt Browser_Type / Crawler um Bots zu erkennen
        \Crossjoin\Browscap\Browscap::setDatasetType(\Crossjoin\Browscap\Browscap::DATASET_TYPE_LARGE);
    
        // set HTTP proxy server (without authentication)
        $updater = new \Crossjoin\Browscap\Updater\Curl();
        /*
        $updater->setOptions(array(
                'ProxyProtocol' => \Crossjoin\Browscap\Updater\AbstractUpdaterRemote::PROXY_PROTOCOL_HTTP,
                'ProxyHost'     => '10.33.102.10',
                'ProxyPort'     => '3128',
        ));*/
        \Crossjoin\Browscap\Browscap::setUpdater($updater);
    
    
        $parser = new \Crossjoin\Browscap\Parser\IniLt55();
        \Crossjoin\Browscap\Browscap::setParser($parser);
    
        \Crossjoin\Browscap\Browscap::update($force); //true = force Update
        //Returns RuntimeExceptions if error on update

        $browscap = new \Crossjoin\Browscap\Browscap();
        $settings = $browscap->getBrowser('Googlebot-Image/1.0')->getData();
        return $settings->crawler;
    }
    
    
    
    
    
    
    
    
    
    
    
}

