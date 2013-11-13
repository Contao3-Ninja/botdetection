<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Modul BotDetection - Frontend
 *
 * @copyright  Glen Langer 2007..2013 <http://www.contao.glen-langer.de>
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
 * @copyright  Glen Langer 2007..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetection
 */
class ModuleBotDetection extends \Frontend
{
	/**
	 * Current version of the class.
	 */
	const BD_VERSION           = '3.2.1';
	
	/**
	 * Rough test - Definition
	 *
	 * @var array
	 */
	private	$_BotsRough = array( 
				            'bot', 
				            'b o t',
				            'spider', 
				            'spyder', 
				            'crawl', 
				            'slurp',
				            'robo',
				            'yahoo',
					    	);
	
	/**
	 * Fine test - Definition
	 *
	 * @var array
	 */
	private $_BotsFine = array( 
							'80legs', 
                            'abonti', // 3.2.0       	        
	                        'acoon', //1.6.0
					        'adressendeutschland',
				            'agentname', 
				            'altavista', 
				            'al_viewer',
				            'appie', 
				            'appengine-google', //http://code.google.com/appengine
				            'arachnoidea', 
				            'archiver',
				            'asterias', 
				            'ask jeeves', 
				            'beholder', 
                            'bildsauger',	// 1.7.0
				            'bingsearch', 
	                        'bingpreview',  // 1.6.2
	                        'bubing',    // 3.2.0
				            'bumblebee',
				            'bramptonmoose',
				            'bbtest-net',	//Hobbit bbtest-net/4.2.0
				            'cherrypicker', 
				            'crescent', 
	                        'coccoc', // 3.1.0
				            'cosmos', 
	                        'curl', // 1.6.2
				            'docomo',
                            'drupact', // 3.0.1
				            'emailsiphon', 
				            'emailwolf', 
				            'extractorpro', 
				            'exalead ng', 
				            'ezresult', 
				            'facebook',
				            'feedfetcher', //Feedfetcher-Google 
				            'fido', 
				            'fireball', 
				            'flashget',
				            'flipboardproxy', // 3.0.1
				            'gazz', 
				            'genieo', // 3.2.0
				            'getright',
				            'getweb',
				            'gigabaz', 
				            'google talk', 
				            'google-site-verification', // Google Webmaster Tools
				            'google web preview',
				            'go!zilla',
				            'gozilla',
				            'gulliver', 
				            'harvester', 
				            'hcat', 
				            'heritrix',
				            'hloader', 
				            'hoge (',
				            'httrack',
				            'hubspot', // 3.2.0
				            'incywincy', 
				            'infoseek', 
				            'infohelfer',    // 3.0.1
				            'inktomi', 
				            'indy library', 
				            'informant', 
				            'internetami', 
				            'internetseer', 
				            'link', 
				            'larbin', 
				            'libweb', 
				            'libwww',
				            'jakarta', // 3.0.1
				            'java', // 1.6.2
				            'mata hari', 
				            'medicalmatrix', 
				            'mercator', 
				            'microsoft url control', //Harvester mit Spamflotte
				            'miixpc', 
				            'moget', 
				            'msnptc', 
				            'muscatferret', 
				            'netcraftsurveyagent',
				            'netants',
				            'openxxx', 
				            'pecl::http', // PECL::HTTP
				            'picmole',
				            'pioneer internet',
				            'piranha', 
				            'pldi.net',
				            'p357x',
				            'quosa', 
				            'rambler',		// russisch
				            'rippers',
							'rganalytics',
				            'scan', 
				            'scooter', 
				            'ScoutJet', 
				            'siclab', // 3.0.1
				            'siteexplorer', // 3.1.0
				            'sly', 
				            'suchen',
				            'searchme',
				            'snoopy',    // 1.6.2 
				            'spy', 
				            'swisssearch', 
				            'sqworm', 
				            'trivial', 
				            't-h-u-n-d-e-r-s-t-o-n-e', 
				            'teoma', 
				            'twiceler',
				            'ultraseek', 
				            'validator',
				            'webbandit',
				            'webmastercoffee',
				            'website extractor',
				            'webwhacker',
				            'wevika', //1.6.0
				            'wget',
				            'wisewire', 
				            'wordpress', //1.6.1
				            'yandex',		// russisch
				            'zend_http_client', // 1.6.2
				            'zyborg'
				            ); 

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
		return self::BD_VERSION;
	} 
		
	/**
	 * Spider Bot Agent Check 
	 * 
	 * @param string   UserAgent, optional for tests
	 * @return boolean true when bot found
	 * @access public
	 */
	public function BD_CheckBotAgent($UserAgent = false)
	{
		// Check if user agent present
   	    if ($UserAgent === false) 
   	    {
   	        if (\Environment::get('httpUserAgent')) 
   	        { 
	           $UserAgent = trim(\Environment::get('httpUserAgent')); 
            } 
            else 
            { 
	           return false; // No user agent, no search.
            }
        }
	    // log_message("ModuleBotDetection BD_CheckBot: ".$UserAgent,"useragents.log");
	    // Rough search
	    $CheckUserAgent = str_ireplace($this->_BotsRough, '#', $UserAgent);
	    if ($UserAgent != $CheckUserAgent) 
	    { // found
            return true;
	    }
	    
        // Fine search
        $CheckUserAgent = str_ireplace($this->_BotsFine, '#', $UserAgent);
        if ($UserAgent != $CheckUserAgent) 
        { // found
            return true;
        }
        
        // Feature #76, search for user bot filter definitions in localconfig.php
        if ( isset($GLOBALS['BOTDETECTION']['BOT_AGENT']) )
        {
            $botagents = array();
            foreach ($GLOBALS['BOTDETECTION']['BOT_AGENT'] as $search)
            {
                $botagents[$search[0]] = $search[1];
            }
            $num = count($botagents);
            $arrBots = array_keys($botagents);
            $found = false;
            for ($c=0; $c < $num; $c++)
            {
                $CheckUserAgent = str_ireplace($arrBots[$c], '#', $UserAgent);
                if ($UserAgent != $CheckUserAgent)
                {   // found
                    return true;
                }
            }
        }
        return false; 
	} //BD_CheckBot
	
	
	/**
	 * Spider Bot IP Check
	 * Detect the IP version and calls the method BD_CheckBotIPv4 respectively BD_CheckBotIPv6.
	 * 
	 * @param string   User IP, optional for tests
	 * @return boolean true when bot found over IP
	 * @access public
	 */
	public function BD_CheckBotIP($UserIP = false)
	{
		// Check if IP present
	    if ($UserIP === false) 
	    {
       	    if (\Environment::get('remoteAddr')) 
       	    {
       	    	if (strpos(\Environment::get('remoteAddr'), ',') !== false) //first IP 
    			{
    				$UserIP =  trim(substr(\Environment::get('remoteAddr'), 0, strpos(\Environment::get('remoteAddr'), ',')));
    			} 
    			else 
    			{
    				$UserIP = trim(\Environment::get('remoteAddr'));
    			}
    	    } 
    	    else 
    	    { 
    	        return false; // No IP, no search.
    	    }
	    }
	    // IPv4 or IPv6 ?
	    switch ($this->IP_GetVersion($UserIP)) 
	    {
	    	case "IPv4":
	    			if ($this->BD_CheckBotIPv4($UserIP) === true) { return true; }
	    		break;
	    	case "IPv6":
	    			if ($this->BD_CheckBotIPv6($UserIP) === true) { return true; }
	    		break;
	    	default:
	    			return false;
	    		break;
	    }
		return false;
	}
	
	/**
	 * Spider Bot IP Check for IPv4
	 * 
	 * @param string   User IP, optional for tests
	 * @return boolean true when bot found over IP
	 * @access protected
	 */
	protected function BD_CheckBotIPv4($UserIP = false)
	{
		// Check if IP present
	    if ($UserIP === false) 
	    {
       	    if (\Environment::get('remoteAddr')) 
       	    {
       	    	if (strpos(\Environment::get('remoteAddr'), ',') !== false) //first IP 
    			{
    				$UserIP =  trim(substr(\Environment::get('remoteAddr'), 0, strpos(\Environment::get('remoteAddr'), ',')));
    			} 
    			else 
    			{
    				$UserIP = trim(\Environment::get('remoteAddr'));
    			}
    	    } 
    	    else 
    	    { 
    	        return false; // No IP, no search.
    	    }
	    }
	    // search user IP in bot-ip-list
	    if (file_exists(TL_ROOT . "/system/modules/botdetection/config/bot-ip-list.txt"))
        {
		    $source = file(TL_ROOT. "/system/modules/botdetection/config/bot-ip-list.txt");
			foreach ($source as $line) 
			{
				$lineleft = explode("#", $line); // Abtrennen Netzwerk/Mask von Bemerkung
				$network = explode("/", trim($lineleft[0]));
				if (!isset($network[1])) 
				{
					$network[1] = 32;
				}
				if ($this->ip_in_network($UserIP,$network[0],$network[1])) 
				{
					return true; // IP found
				}
			}
		}
		// search for user bot IP-filter definitions in localconfig.php
		// (old name for backward compatibility)
		if ( isset($GLOBALS['TL_BOTDETECTION']['BOT_IP']) ) 
		{
	    	foreach ($GLOBALS['TL_BOTDETECTION']['BOT_IP'] as $lineleft) 
	    	{
	    		//$GLOBALS['TL_DEBUG']['BOTDETECTION'][] = $lineleft; 
	    		$network = explode("/", trim($lineleft));
				if (!isset($network[1])) 
				{
					$network[1] = 32;
				}
				if ($this->ip_in_network($UserIP,$network[0],$network[1])) 
				{
					return true; // IP found
				}
	    	}
    	}
    	// search for user bot IP-filter definitions in localconfig.php
    	if ( isset($GLOBALS['BOTDETECTION']['BOT_IP']) ) 
		{
	    	foreach ($GLOBALS['BOTDETECTION']['BOT_IP'] as $lineleft) 
	    	{
	    		//$GLOBALS['TL_DEBUG']['BOTDETECTION'][] = $lineleft; 
	    		$network = explode("/", trim($lineleft));
				if (!isset($network[1])) 
				{
					$network[1] = 32;
				}
				if ($this->ip_in_network($UserIP,$network[0],$network[1])) 
				{
					return true; // IP found
				}
	    	}
    	}
		return false;
	}
	
	/**
	 * Spider Bot IP Check for IPv6
	 * 
	 * @param string   User IP, optional for tests
	 * @return boolean true when bot found over IP
	 * @access protected
	 */
	protected function BD_CheckBotIPv6($UserIP = false)
	{
		// Check if IP present
	    if ($UserIP === false) 
	    {
       	    if (\Environment::get('remoteAddr')) 
       	    {
       	    	if (strpos(\Environment::get('remoteAddr'), ',') !== false) //first IP 
    			{
    				$UserIP =  trim(substr(\Environment::get('remoteAddr'), 0, strpos(\Environment::get('remoteAddr'), ',')));
    			} 
    			else 
    			{
    				$UserIP = trim(\Environment::get('remoteAddr'));
    			}
    	    } 
    	    else 
    	    { 
    	        return false; // No IP, no search.
    	    }
	    }
	    //$UserIP = $this->IPv6_ToLong($UserIP);
	    // search user IP in bot-ip-list-ipv6
	    if (file_exists(TL_ROOT . "/system/modules/botdetection/config/bot-ip-list-ipv6.txt"))
        {
		    $source = file(TL_ROOT. "/system/modules/botdetection/config/bot-ip-list-ipv6.txt");
			foreach ($source as $line) 
			{
				$lineleft = explode("#", $line); // Abtrennen IP von Bemerkung
				$network = explode("/", trim($lineleft[0]));
				if (!isset($network[1])) 
				{
					$network[1] = 128;
				}
				if ($this->IPv6_InNetwork($UserIP,$network[0],$network[1])) 
				{
					return true; // IP found
				}
				/*
				// fullIP wandeln und vergleichen
				if ($this->IPv6_ToLong(trim($lineleft[0])) == $UserIP ) 
				{
					return true;
				}*/
			}
		}
		// search for user bot IP-filter definitions in localconfig.php
    	if ( isset($GLOBALS['BOTDETECTION']['BOT_IPV6']) ) 
		{
	    	foreach ($GLOBALS['BOTDETECTION']['BOT_IPV6'] as $lineleft) 
	    	{
	    		$network = explode("/", trim($lineleft));
				if (!isset($network[1])) 
				{
					$network[1] = 128;
				}
				if ($this->IPv6_InNetwork($UserIP,$network[0],$network[1])) 
				{
					return true; // IP found
				}
				/*
	    		if ($this->IPv6_ToLong(trim($lineleft)) == $UserIP ) {
					return true;
				}*/
	    	}
    	}
		return false;
	}
	
	/**
	 * Helperfunction, Replace '::' with appropriate number of ':0'
	 *
	 * @param string $Ip	IP Address
	 * @return string		IP Address expanded
	 * @access protected
	 */
	protected function IPv6_ExpandNotation($Ip) 
	{
	    if (strpos($Ip, '::') !== false)
	    {
	        $Ip = str_replace('::', str_repeat(':0', 8 - substr_count($Ip, ':')).':', $Ip);
	    }
	    if (strpos($Ip, ':') === 0) 
	    {
	    	$Ip = '0'.$Ip;
	    }
	    return $Ip;
	}
	
	/**
	 * Helperfunction, Convert IPv6 address to an integer
	 *
	 * Optionally split in to two parts.
	 *
	 * @see http://stackoverflow.com/questions/420680/
	 * @param string $Ip			IP Address
	 * @param int $DatabaseParts	1 = one part, 2 = two parts (array)
	 * @return mixed				string      / array
	 * @access protected
	 */
	protected function IPv6_ToLong($Ip, $DatabaseParts= 1) 
	{
	    $Ip = $this->IPv6_ExpandNotation($Ip);
	    $Parts = explode(':', $Ip);
	    $Ip = array('', '');
	    for ($i = 0; $i < 4; $i++) 
	    {
	    	$Ip[0] .= str_pad(base_convert($Parts[$i], 16, 2), 16, 0, STR_PAD_LEFT);
	    }
	    for ($i = 4; $i < 8; $i++) 
	    {
	    	$Ip[1] .= str_pad(base_convert($Parts[$i], 16, 2), 16, 0, STR_PAD_LEFT);
	    }
	
	    if ($DatabaseParts == 2)
	    {
	    	return array(base_convert($Ip[0], 2, 10), base_convert($Ip[1], 2, 10));
	    }	            
	    else
	    {
	    	return base_convert($Ip[0], 2, 10) + base_convert($Ip[1], 2, 10);
	    }
	}
	
	
	/**
	 * Helperfunction, if IPv6 in NET_ADDR/PREFIX
	 *
	 * @param string $UserIP
	 * @param string $net_addr
	 * @param integer $net_mask
	 * @return boolean
	 * @access public
	 */
	public function IPv6_InNetwork($UserIP, $net_addr=0, $net_mask=0)
	{
		if ($net_mask <= 0) 
	    { 
	    	return false; 
	    }
	    // UserIP to bin
	    $UserIP = $this->IPv6_ExpandNotation($UserIP);
	    $Parts  = explode(':', $UserIP);
	    $Ip = array('', '');
	    for ($i = 0; $i < 8; $i++) 
	    {
	    	$Ip[0] .= str_pad(base_convert($Parts[$i], 16, 2), 16, 0, STR_PAD_LEFT);
	    }
	    // NetAddr to bin
	    $net_addr = $this->IPv6_ExpandNotation($net_addr);
	    $Parts    = explode(':', $net_addr);
	    for ($i = 0; $i < 8; $i++) 
	    {
	    	$Ip[1] .= str_pad(base_convert($Parts[$i], 16, 2), 16, 0, STR_PAD_LEFT);
	    }
	    // compare the IPs
	    return (substr_compare($Ip[0],$Ip[1],0,$net_mask) === 0);	    
	}
	
	
	
	/**
	 * Helperfunction, if IPv4 in NET_ADDR/NET_MASK
	 *
	 * @param string $ip		IPv4 Address
	 * @param string $net_addr	Network, optional
	 * @param int    $net_mask	Mask, optional
	 * @return boolean
	 * @access public
	 */
	public function ip_in_network($ip, $net_addr=0, $net_mask=0)
	{
	    if ($net_mask <= 0) 
	    { 
	    	return false; 
	    }
	    if (ip2long($net_addr)===false) 
	    {
	    	return false; //no IP
	    }
	    //php.net/ip2long : jwadhams1 at yahoo dot com
        $ip_binary_string  = sprintf("%032b",ip2long($ip));
        $net_binary_string = sprintf("%032b",ip2long($net_addr));
        return (substr_compare($ip_binary_string,$net_binary_string,0,$net_mask) === 0);
	}
	
	/**
	 * Helperfunction, IP =  IPv4 or IPv6 ?
	 *
	 * @param string $ip	IP Address (IPv4 or IPv6)
	 * @return mixed		false: no valid IPv4 and no valid IPv6
	 * 						"IPv4" : IPv4 Address
	 * 						"IPv6" : IPv6 Address
	 * @access public
	 */
	public function IP_GetVersion($ip)
	{
		// Test for IPv4
		if (ip2long($ip) !== false) 
	    {
	    	return "IPv4";
	    }
	    
	    
	    // Test for IPv6
	    
	    if (substr_count($ip, ":" ) < 2) return false; // ::1 or 2001::0db8
		if (substr_count($ip, "::") > 1) return false; // one allowed
		$groups = explode(':', $ip);
		$num_groups = count($groups);
		if (($num_groups > 8) || ($num_groups < 3)) return false; 
		$empty_groups = 0;
		foreach ($groups as $group) 
		{
			$group = trim($group);
			if (!empty($group) && !(is_numeric($group) && ($group == 0))) 
			{
				if (!preg_match('#([a-fA-F0-9]{0,4})#', $group)) return false;
			} 
			else 
			{
				++$empty_groups;
			}
		}
		if ($empty_groups < $num_groups) 
		{
			return "IPv6";
		} 
		return false; // no (valid) IP Address
	}
	
	/////////////// ADVANCED SEARCH //////////////////////
	/**
	 * Spider Bot Agent Check Advanced
	 *
	 * @param string	UserAgent, optional for tests	
	 * @return mixed	false (not bot) or short Bot-Agentname
	 * @access public
	 */
	public function BD_CheckBotAgentAdvanced($UserAgent = false)
	{
   	    if ($UserAgent === false) 
   	    {
   	        if (\Environment::get('httpUserAgent')) 
   	        { 
	           $UserAgent = trim(\Environment::get('httpUserAgent')); 
            } 
            else 
            { 
	           return false; // No return address, no search.
            }
        }
        // include bot-agent-list
        if (file_exists(TL_ROOT . "/system/modules/botdetection/config/bot-agent-list.php")) 
        {
        	include(TL_ROOT . "/system/modules/botdetection/config/bot-agent-list.php");
        } 
        else 
        {
        	return false;	// no definition, no search
        }
        // search for user bot filter definitions in localconfig.php
        // (old name for backward compatibility)
        if ( isset($GLOBALS['TL_BOTDETECTION']['BOT_AGENT']) ) 
        {
	    	foreach ($GLOBALS['TL_BOTDETECTION']['BOT_AGENT'] as $search) 
	    	{
	    		$botagents[$search[0]] = $search[1];
	    	}
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
            { // found
                $found = $botagents[$arrBots[$c]];
                //echo $found."<br>";
            }
        }
        return $found;
	}
	
	/**
	 * Spider Bot Agent/Advanced/IP Check
	 *
	 * @param string   UserAgent, optional for tests
	 * @return boolean true when bot found
	 * @access public
	 */
	public function BD_CheckBotAllTests($UserAgent = false)
	{
	    if ( $this->BD_CheckBotAgent($UserAgent) == true ) 
	    {
	        return true;
	    }
	    elseif ( $this->BD_CheckBotAgentAdvanced($UserAgent) == true )
	    {
	        return true;
	    }
	    else 
	    {
	        return $this->BD_CheckBotIP();
	    }
	}
}

