<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2015 Leo Feyer
 *
 * Modul Browscap Cache - Frontend
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
 * Class ModuleBrowscapCache
 *
 * @copyright  Glen Langer 2007..2015 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetection
 */
class ModuleBrowscapCache extends \Module
{
   
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_botdetection_browscap_fe';
    
    
    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ModuleBrowscapCache Generator ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
    
            return $objTemplate->parse();
        }
        return parent::generate();
    }
    
    /**
     * Generate module
     */
    protected function compile()
    {
        $cachdir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cache';
        //before
        $before_path = '';
        if (!file_exists($cachdir . DIRECTORY_SEPARATOR . 'largebrowscap.version'))
        {
            $before = '---';
        }
        else 
        {
            $before = file_get_contents($cachdir . DIRECTORY_SEPARATOR . 'largebrowscap.version');

            $arrCacheDir = scan($cachdir,true); // nicht cachen
            foreach ($arrCacheDir as $dirs) 
            {
            	if (0 === substr_compare( basename($dirs), 'largebrowscap_v', 0,15)) 
            	{
            		$before_path .= '<br>- ' . $dirs ;
            	}
            }
        }
        
        $arrProxy   = false;
        //Daten aus localconfig sofern Proxyerweiterung installiert und aktiv als Parameter
        if ( \Config::get('useProxy') && in_array('proxy', \ModuleLoader::getActive()) )
        {
            $parsedUrl = parse_url(\Config::get('proxy_url'));
            $arrProxy['ProxyProtocol'] = (isset($parsedUrl['scheme'])) ? $parsedUrl['scheme'] : null;  
            $arrProxy['ProxyHost']     = (isset($parsedUrl['host']))   ? $parsedUrl['host']   : null;
            $arrProxy['ProxyPort']     = (isset($parsedUrl['port']))   ? $parsedUrl['port']   : null;
            $arrProxy['ProxyUser']     = (isset($parsedUrl['user']))   ? $parsedUrl['user']   : null;
            $arrProxy['ProxyPassword'] = (isset($parsedUrl['pass']))   ? $parsedUrl['pass']   : null;
        }
        //Using Class BrowscapCache
        $return = BrowscapCache::generateBrowscapCache(false, $arrProxy);
        
        if (!file_exists($cachdir . DIRECTORY_SEPARATOR . 'largebrowscap.version'))
        {
            $return = $cachdir . DIRECTORY_SEPARATOR . 'largebrowscap.version not found';
            $after  = '---';
        }
        else
        {
            $return = 'Cache generated.';
            $after  = file_get_contents($cachdir . DIRECTORY_SEPARATOR . 'largebrowscap.version');
            $after_path  = $cachdir . DIRECTORY_SEPARATOR . 'largebrowscap';
            $after_path .= '_v' . $after;
            $after_path .= '_' . \Crossjoin\Browscap\Browscap::VERSION;
        }
        
        $this->Template->before      = $before;
        $this->Template->before_path = $before_path;
        $this->Template->after       = $after;
        $this->Template->after_path  = basename($after_path);
        $this->Template->return      = $return;
        
    }
    
    
    
    
    
    
}
