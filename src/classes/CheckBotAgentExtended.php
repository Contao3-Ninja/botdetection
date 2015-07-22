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
 * Class CheckBotAgentExtended 
 *
 * @copyright  Glen Langer 2015 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetection
 */
class CheckBotAgentExtended
{
    // TODO - Insert your code here
    
    /**
     */
    function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    
    public static function checkAgent($UserAgent=false)
    {
        // Check if user agent present
        if ($UserAgent === false)
        {
            return false; // No user agent, no search.
        }
    
        $UserAgent = trim( $UserAgent );
        if (false === (bool) $UserAgent)
        {
            return false; // No user agent, no search.
        }
    
        //Search in browsecap
        $objBrowscap = static::getBrowscapInfo($UserAgent);
        if ($objBrowscap->crawler == true) 
        {
            return true;
        }
        
        //Search in own extended list  
    
    
    
    
    }
    
    /**
     * Get Browscap info for the user agent string
     * 
     * @param string $UserAgent
     * @return stdClass Object
     */
    protected static function getBrowscapInfo($UserAgent=false)
    {
        // Check if user agent present
        if ($UserAgent === false)
        {
            return false; // No user agent, no search.
        }
        
        // set an own cache directory (otherwise the system temp directory is used)
        \Crossjoin\Browscap\Cache\File::setCacheDirectory(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cache');
        
        //Large sonst fehlt Browser_Type / Crawler um Bots zu erkennen
        \Crossjoin\Browscap\Browscap::setDatasetType(\Crossjoin\Browscap\Browscap::DATASET_TYPE_LARGE);

        // disable automatic updates 
        $updater = new \Crossjoin\Browscap\Updater\None(); 
        \Crossjoin\Browscap\Browscap::setUpdater($updater);
        
        $parser = new \Crossjoin\Browscap\Parser\IniLt55();
        \Crossjoin\Browscap\Browscap::setParser($parser);
        
        $browscap = new \Crossjoin\Browscap\Browscap();
        $settings = $browscap->getBrowser($UserAgent)->getData();
        
        return $settings;
        /*
            stdClass Object
            (
                [browser_name_regex] => /^Yandex\/1\.01\.001 \(compatible; Win16; .*\)$/
                [browser_name_pattern] => Yandex/1.01.001 (compatible; Win16; *)
                [parent] => Yandex
                [comment] => Yandex
                [browser] => Yandex
                [browser_type] => Bot/Crawler
                [browser_maker] => Yandex
                [crawler] => true
                .....
            stdClass Object
            (
                [browser_name_regex] => /^Googlebot\-Image.*$/
                [browser_name_pattern] => Googlebot-Image*
                [parent] => Googlebot
                [browser] => Googlebot-Image
                [comment] => Googlebot
                [browser_type] => Bot/Crawler
                [browser_maker] => Google Inc
                [crawler] => true
                .....
         */
    }
    
    
    
    
    
    
    
    
    
    
    
}

