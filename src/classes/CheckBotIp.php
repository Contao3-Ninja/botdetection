<?php
namespace BugBuster\BotDetection;

/**
 *
 * @author bibo
 *        
 */
class CheckBotIp
{
    
    protected static $bot_ipv4_list;
    protected static $bot_ipv6_list;
    
    
    public static function setBotIpv4List($bot_ipv4_list)
    {
        static::$bot_ipv4_list = $bot_ipv4_list;
    }
    
    public static function setBotIpv6List($bot_ipv6_list)
    {
        static::$bot_ipv6_list = $bot_ipv6_list;
    }
    
    public static function getBotIpv4List()
    {
        return static::$bot_ipv4_list;
    }
    
    public static function getBotIpv6List()
    {
        return static::$bot_ipv6_list;
    }
    
    /**
     * Spider Bot IP Check
     * Detect the IP version and calls the method checkBotIPv4 respectively checkBotIPv6.
     *
     * @param string   User IP, optional for tests
     * @return boolean true when bot found over IP
     * @access public
     */
    public static function checkIP($UserIP = false)
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
        switch (static::getIpVersion($UserIP))
        {
        	case "IPv4":
        	    if ( static::checkBotIPv4($UserIP, static::getBotIpv4List()) === true) { return true; }
        	    break;
        	case "IPv6":
        	    if ( static::checkBotIPv6($UserIP, static::getBotIpv6List()) === true) { return true; }
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
     * @param string $Bot_IPv4_List   Bot IPv6 List, absolute Path+Filename including TL_ROOT
     * @access protected
     */
    protected static function checkBotIPv4($UserIP = false, $Bot_IPv4_List = false)
    {
        if (false === $Bot_IPv4_List) 
        {
        	return false;
        }
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
        if (file_exists($Bot_IPv4_List))
        {
            $source = file($Bot_IPv4_List);
            foreach ($source as $line)
            {
                $lineleft = explode("#", $line); // Abtrennen Netzwerk/Mask von Bemerkung
                $network = explode("/", trim($lineleft[0]));
                if (!isset($network[1]))
                {
                    $network[1] = 32;
                }
                if (static::checkIp4InNetwork($UserIP,$network[0],$network[1]))
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
                if (static::checkIp4InNetwork($UserIP,$network[0],$network[1]))
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
                if (static::checkIp4InNetwork($UserIP,$network[0],$network[1]))
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
     * @param string $Bot_IPv6_List   Bot IPv6 List, absolute Path+Filename including TL_ROOT
     * @return boolean true when bot found over IP
     * @access protected
     */
    protected static function checkBotIPv6($UserIP = false, $Bot_IPv6_List = false)
    {
        if (false === $Bot_IPv6_List)
        {
            return false;
        }
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
        if (file_exists($Bot_IPv6_List))
        {
            $source = file($Bot_IPv6_List);
            foreach ($source as $line)
            {
                if ($line[0] === '#') 
                {
                	continue;
                }
                $lineleft = explode("#", $line); // Abtrennen IP von Bemerkung
                $network = explode("/", trim($lineleft[0]));

                if (!isset($network[1]))
                {
                    $network[1] = 128;
                }
                if (static::checkIp6InNetwork($UserIP,$network[0],$network[1]))
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
                if (static::checkIp6InNetwork($UserIP,$network[0],$network[1]))
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
    protected static function expandNotationIpv6($Ip)
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
    protected static function getIpv6ToLong($Ip, $DatabaseParts= 1)
    {
        $Ip = static::expandNotationIpv6($Ip);
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
    protected static function checkIp6InNetwork($UserIP, $net_addr=0, $net_mask=0)
    {
        if ($net_mask <= 0)
        {
            return false;
        }
        // UserIP to bin
        $UserIP = static::expandNotationIpv6($UserIP);
        $Parts  = explode(':', $UserIP);
        $Ip = array('', '');
        for ($i = 0; $i < 8; $i++)
        {
            $Ip[0] .= str_pad(base_convert($Parts[$i], 16, 2), 16, 0, STR_PAD_LEFT);
        }
        // NetAddr to bin
        $net_addr = static::expandNotationIpv6($net_addr);
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
    protected static function checkIp4InNetwork($ip, $net_addr=0, $net_mask=0)
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
    protected static function getIpVersion($ip)
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
    	
    	
    	
    	
    	
    	
}

