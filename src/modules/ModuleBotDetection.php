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
 * @copyright  Glen Langer 2007..2015 <http://contao.ninj>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetection
 */
class ModuleBotDetection extends \Frontend
{
    
    /**
     * Current version of the class.
     */
    const BOTDETECTION_VERSION  = '4.0.0';
    
    const BOT_REFERRER_LIST     = "/system/modules/botdetection/config/bot-referrer-list.php";
    
    const BOT_IP4_LIST          = "/system/modules/botdetection/config/bot-ip-list-ipv4.txt";
    const BOT_IP6_LIST          = "/system/modules/botdetection/config/bot-ip-list-ipv6.txt";
    
    /**
     * Initialize object
     */
    public function __construct()
    {
        // Issue #59
        $this->getUser();
        parent::__construct();
    }
    
    /**
     * Returns the proper user object for the current context.
     *
     * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
     * @return     User|NULL
     */
    protected function getUser()
    {
        if (TL_MODE=='BE')
        {
            return \BackendUser::getInstance();
        }
        else if(TL_MODE=='FE')
        {
            return \FrontendUser::getInstance();
        }
        return null;
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
        if ( $this->BD_CheckBotAgent($UserAgent) == true )
        {
            return true;
        }
        
        if ( \BugBuster\BotDetection\CheckBotReferrer::checkReferrer(false, TL_ROOT . self::BOT_REFERRER_LIST) == true )
        {
            return true;
        }

        \BugBuster\BotDetection\CheckBotIp::setBotIpv4List(TL_ROOT . self::BOT_IP4_LIST);
        \BugBuster\BotDetection\CheckBotIp::setBotIpv6List(TL_ROOT . self::BOT_IP6_LIST);
        if ( \BugBuster\BotDetection\CheckBotIp::checkIP() == true )
        {
            return true;
        }
        else
        {
            return $this->BD_CheckBotAgentAdvanced($UserAgent);
        }
    }
    
    
    
    
    
    
}
