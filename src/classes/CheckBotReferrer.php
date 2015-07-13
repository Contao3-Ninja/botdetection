<?php
namespace BugBuster\BotDetection;

/**
 *
 * @author bibo
 *        
 */
class CheckBotReferrer
{
    // TODO - Insert your code here
    
    /**
     */
    function __construct()
    {
        
        // TODO - Insert your code here
    }
    
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
            $this->_http_referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'unknown' ;
        }
        else
        {
            $this->_http_referrer = $Referrer;
        }
        //nur den host Anteil prüfen
        $this->_referrer_DNS = parse_url( $this->_http_referrer, PHP_URL_HOST );
        if ($this->_referrer_DNS === NULL)
        {
            //try this...
            $this->_referrer_DNS = @parse_url( 'http://'.$this->_http_referrer, PHP_URL_HOST );
            if ($this->_referrer_DNS === NULL ||
                $this->_referrer_DNS === false)
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
            $CheckBotRef = str_ireplace($botreferrer, '#', $this->_referrer_DNS);
            if ($this->_referrer_DNS != $CheckBotRef)
            {
                //echo "DEBUG: ".$botreferrer."\n";
                $found = $botreferrer;
            };
        }
        return $found;
    }
}

