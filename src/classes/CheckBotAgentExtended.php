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
    
    public static function checkAgent($UserAgent=false, $ouputBotName = false)
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
        // DEBUG fwrite(STDOUT, 'BrowscapInfo: '.print_r($objBrowscap,true) . "\n");
        if ($objBrowscap->crawler == 'true') 
        {
            if (false === $ouputBotName) 
            {
            	return true;
            }
            else 
            {
                // DEBUG fwrite(STDOUT, "\n" . 'Agent: '.print_r($UserAgent,true) . "\n");
                // DEBUG fwrite(STDOUT, 'Bot: '.print_r($objBrowscap->browser_type,true) . "\n");
                return $objBrowscap->browser;
            }
            
        }
        
        // Search in bot-agent-list
        if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config/bot-agent-list.php'))
        {
            include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config/bot-agent-list.php');
        }
        else
        {
            return false;	// no definition, no search
        }
        // search for user bot filter definitions in localconfig.php
        if ( isset($GLOBALS['BOTDETECTION']['BOT_AGENT']) )
        {
            foreach ($GLOBALS['BOTDETECTION']['BOT_AGENT'] as $search)
            {
                $botagents[$search[0]] = $search[1];
            }
        }
        $num = count($botagents);
        $arrBots = array_keys($botagents);
        $found = false;
        for ($c=0; $c < $num; $c++)
        {
            $CheckUserAgent = str_ireplace($arrBots[$c], '#', $UserAgent);
            if ($UserAgent != $CheckUserAgent)
            {   // found
                // Debug fwrite(STDOUT, 'Bot: '.print_r($botagents[$arrBots[$c]],true) . "\n");
                if (false === $ouputBotName)
                {
                    return true;
                }
                else 
                {
                    return $botagents[$arrBots[$c]];
                }
            }
        }
    
        return false;
    }
    
    public static function checkAgentName($UserAgent=false)
    {
        $BotName = static::checkAgent($UserAgent,true); 
        return ($BotName) ? $BotName : 'unknown';
    }
    
    /**
     * getBrowscapResult for Debug
     * 
     */
    public static function getBrowscapResult($UserAgent=false)
    {
        return static::getBrowscapInfo($UserAgent=false);
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
        
        //$parser = new \Crossjoin\Browscap\Parser\IniLt55();
        //\Crossjoin\Browscap\Browscap::setParser($parser);
        
        $browscap = new \Crossjoin\Browscap\Browscap(false); //autoUpdate = false
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
