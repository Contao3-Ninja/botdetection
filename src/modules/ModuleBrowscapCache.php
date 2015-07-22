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
        //TODO Class BrowscapCache
        //TODO Daten aus localconfig sofern Proxyerweiterung installiert und aktiv als Parameter
    }
    
    
    
    
    
    
}
