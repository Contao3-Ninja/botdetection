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
    /**
     * Generate Browscap Cache
     * 
     * @param  bool    $force       true: force the generate; false: generate only when cache older then 5 days
     * @param  array   $arrProxy    false: no proxy; array('ProxyHost' => '192.168.17.01', 'ProxyPort' => 3128)
     * @return string  $settings->crawler    "true" as string   
     */
    public static function generateBrowscapCache($force=false, $arrProxy=false)
    {
        // set an own cache directory (otherwise the system temp directory is used)
        \Crossjoin\Browscap\Cache\File::setCacheDirectory(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cache');
    
        //Large sonst fehlt Browser_Type / Crawler um Bots zu erkennen
        \Crossjoin\Browscap\Browscap::setDatasetType(\Crossjoin\Browscap\Browscap::DATASET_TYPE_LARGE);
    
        
        $updater = new \Crossjoin\Browscap\Updater\Curl();
        
        // set HTTP proxy server (without authentication)
        if (false !== $arrProxy) 
        {
            $updater->setOptions(array(
                    'ProxyProtocol' => $arrProxy['ProxyProtocol'],
                    'ProxyHost'     => $arrProxy['ProxyHost'],
                    'ProxyPort'     => $arrProxy['ProxyPort'],
                    'ProxyUser'     => $arrProxy['ProxyUser'],
                    'ProxyPassword' => $arrProxy['ProxyPassword']
            ));
        }
        
        \Crossjoin\Browscap\Browscap::setUpdater($updater);
    
    
        $parser = new \Crossjoin\Browscap\Parser\IniLt55();
        \Crossjoin\Browscap\Browscap::setParser($parser);
    
        //Bei Bedarf eine neue largebrowscap.ini laden (10-12 Sekunden)
        \Crossjoin\Browscap\Browscap::update($force); //true = force Update
        //Returns RuntimeExceptions if error on update

        //Cache Dateien aus der ini generieren lassen (5-12 Sekunden)
        $browscap = new \Crossjoin\Browscap\Browscap();
        $settings = $browscap->getBrowser('Googlebot-Image/1.0')->getData();
        return $settings->crawler;
    }
    
    
}
