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
 * Class CheckBotReferrer 
 *
 * @copyright  Glen Langer 2015 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetection
 */
class CheckBotReferrer
{
 
    /**
     * checkReferrer
     * 
     * @param string $Referrer          Referrer of Request
     * @param string $BotReferrerList   Bot Referrer List, absolute Path+Filename including TL_ROOT
     * @return boolean|Ambigous <boolean, string>
     */
    public static function checkReferrer($Referrer = false, $Bot_Referrer_List = false)
    {
        if (false === $Bot_Referrer_List) 
        {
        	return false;
        }
        
        $found = false;
        $botreferrerlist = array();
        
        if ($Referrer === false)
        {
            $http_referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'unknown' ;
        }
        else
        {
            $http_referrer = $Referrer;
        }
        //nur den host Anteil prüfen
        $referrer_DNS = parse_url( $http_referrer, PHP_URL_HOST );
        if ($referrer_DNS === NULL)
        {
            //try this...
            $referrer_DNS = @parse_url( 'http://'.$http_referrer, PHP_URL_HOST );
            if ($referrer_DNS === NULL ||
                $referrer_DNS === false)
            {
                //wtf...
                return false;
            }
        }
        // include bot-referrer-list $botreferrerlist
        if (file_exists($Bot_Referrer_List))
        {
            include($Bot_Referrer_List);
        }
        else
        {
            return false;	// no definition, no search
        }
         
        //Prüfung
        foreach ($botreferrerlist as $botreferrer)
        {
            $CheckBotRef = str_ireplace($botreferrer, '#', $referrer_DNS);
            if ($referrer_DNS != $CheckBotRef)
            {
                //echo "DEBUG: ".$botreferrer."\n";
                $found = $botreferrer;
            };
        }
        return $found;
    }
}

