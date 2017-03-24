<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2015 Leo Feyer
 *
 * Modul BotDetection - Frontend
 *
 * @copyright  Glen Langer 2007..2015 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetection
 * @license    LGPL
 * @filesource
 * @see        https://github.com/BugBuster1701/botdetection
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\BotDetection;

/**
 * Class ModuleBotDetection
 *
 * @copyright  Glen Langer 2007..2015 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetection
 */
class ModuleBotDetection extends \System
{

    /**
     * Current version of the class.
     */
    const BOTDETECTION_VERSION  = '4.2.2';

    const BOT_REFERRER_LIST     = "/system/modules/botdetection/config/bot-referrer-list.php";

    const BOT_IP4_LIST          = "/system/modules/botdetection/config/bot-ip-list-ipv4.txt";
    const BOT_IP6_LIST          = "/system/modules/botdetection/config/bot-ip-list-ipv6.txt";

    /**
     * Initialize object
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns the version number
     *
     * @return string
     * @access public
     */
    public function getVersion()
    {
        return self::BOTDETECTION_VERSION;
    }



    /**
     * Spider Bot Agent/Advanced/Referrer/IP Check
     *
     * @param string   UserAgent, optional for tests
     * @return boolean true when bot found
     * @access public
     */
    public function checkBotAllTests($UserAgent = false)
    {
        if (false === $UserAgent)
        {
        	$UserAgent = \Environment::get('httpUserAgent');
        }
        if ( \BugBuster\BotDetection\CheckBotAgentSimple::checkAgent( $UserAgent ) === true ) //(BotsRough, BotsFine)
        {
            return true;
        }

        if ( true === (bool) \BugBuster\BotDetection\CheckBotReferrer::checkReferrer(false, TL_ROOT . self::BOT_REFERRER_LIST) )
        {
            return true;
        }

        if ( false === $this->checkGetPostRequest() ) // #153
        {
            return true;
        }

        \BugBuster\BotDetection\CheckBotIp::setBotIpv4List(TL_ROOT . self::BOT_IP4_LIST);
        \BugBuster\BotDetection\CheckBotIp::setBotIpv6List(TL_ROOT . self::BOT_IP6_LIST);

        if ( true === \BugBuster\BotDetection\CheckBotIp::checkIP() )
        {
            return true;
        }
        else
        {
            //CheckBotAgentExtended (Browscap + eigene Liste)
            return \BugBuster\BotDetection\CheckBotAgentExtended::checkAgent( $UserAgent );
        }
    }

    /**
     * Check if Request a GET/POST Request
     *
     * @return boolean  true when GET/POST
     * @access public
     */
    public function checkGetPostRequest()
    {
        $RequestMethod = \Environment::get('requestMethod');
        if ($RequestMethod == 'GET' || $RequestMethod == 'POST')
        {
        	 return true;
        }

        return false;
    }

    /////////////// Deprecated Methods ///////////////

    /**
     * Spider Bot Agent Check
     *
     * @param string   UserAgent, optional for tests
     * @return boolean true when bot found
     * @deprecated Use the CheckBotAgentSimple class instead or the method checkBotAllTests
     */
    public function BD_CheckBotAgent($UserAgent = false)
    {
        // Check if user agent present
        if ($UserAgent === false)
        {
            $UserAgent = trim(\Environment::get('httpUserAgent'));
        }
        return \BugBuster\BotDetection\CheckBotAgentSimple::checkAgent( $UserAgent );
    }

    /**
     * Spider Bot IP Check
     *
     * @param string   User IP, optional for tests
     * @return boolean true when bot found over IP
     * @deprecated Use the CheckBotIp class instead
     */
    public function BD_CheckBotIP($UserIP = false)
    {
        // Check if IP present
        if ($UserIP === false)
        {
            if (strpos(\Environment::get('ip'), ',') !== false) //first IP
            {
				$UserIP = trim(substr(\Environment::get('ip'), 0, strpos(\Environment::get('ip'), ',')));
            }
            else
            {
				$UserIP = trim(\Environment::get('ip'));
            }
        }
        \BugBuster\BotDetection\CheckBotIp::setBotIpv4List(TL_ROOT . self::BOT_IP4_LIST);
        \BugBuster\BotDetection\CheckBotIp::setBotIpv6List(TL_ROOT . self::BOT_IP6_LIST);
        return \BugBuster\BotDetection\CheckBotIp::checkIP( $UserIP );
    }

    /**
     * Spider Bot Agent Check Advanced
     *
     * @param string	UserAgent, optional for tests
     * @return bool	    false (not bot) or true (bot), in old version the short Bot-Agentname
     * @deprecated Use the CheckBotAgentExtended class instead or the method checkBotAllTests
     */
    public function BD_CheckBotAgentAdvanced($UserAgent = false)
    {
        if ($UserAgent === false)
        {
                $UserAgent = trim(\Environment::get('httpUserAgent'));
        }
        return \BugBuster\BotDetection\CheckBotAgentExtended::checkAgentName( $UserAgent );
    }

    /**
     * CheckBotReferrer
     *
     * @param string $Referrer
     * @deprecated Use the CheckBotReferrer class instead or the method checkBotAllTests
     */
    public function BD_CheckBotReferrer($Referrer = false)
    {
        return \BugBuster\BotDetection\CheckBotReferrer::checkReferrer($Referrer, TL_ROOT . self::BOT_REFERRER_LIST);
    }

    /**
     * Spider Bot Agent/Advanced/Referrer/IP Check
     *
     * @param string   UserAgent, optional for tests
     * @return boolean true when bot found
     * @access public
     * @deprecated Use the method checkBotAllTests
     */
    public function BD_CheckBotAllTests($UserAgent = false)
    {
        return $this->checkBotAllTests($UserAgent);
    }
}
