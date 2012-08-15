<?php 
/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @link http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 * 
 * PHP version 5
 * @copyright  Glen Langer 2012
 * @author     BugBuster 
 * @package    BotDetectionDemo 
 * @license    LGPL 
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\BotDetection;

if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class ModuleFrontendDemo1
 * Use ModuleBotDetection with import function
 *
 * @copyright  Glen Langer 2007..2012
 * @author     Glen Langer 
 * @package    BotDetectionDemo
 */
class ModuleFrontendDemo1 extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_botdetection_demo1_fe';
	
	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### Bot Detection Frontend Demo 1 ###';
			
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
	    // Import Helperclass ModuleBotDetection
	    $this->import('\BotDetection\ModuleBotDetection','ModuleBotDetection'); //Workaround for $this->ModuleBotDetection->...
	    //Call BD_CheckBotAgent
	    $test01 = $this->ModuleBotDetection->BD_CheckBotAgent(); // own Browser
	    //Call BD_CheckBotIP
	    $test02 = $this->ModuleBotDetection->BD_CheckBotIP(); // own IP
	    //Call BD_CheckBotAgentAdvanced
	    $test03 = $this->ModuleBotDetection->BD_CheckBotAgentAdvanced(); // own Browser
	    
	    //for fe template
	    $arrDemo[] = array(
	       'type'          => 'agent',
	       'test'          => '01',
	       'theoretical'   => 'false',
	       'actual'        => var_export($test01,true),
	       'comment'       => '<br />'.\Environment::get('httpUserAgent'),
	       'color'         => ($test01 == false) ? 'green' : 'red'
	    );
	    $arrDemo[] = array(
	       'type'          => 'ip',
	       'test'          => '02',
	       'theoretical'   => 'false',
	       'actual'        => var_export($test02,true),
	       'comment'       => '<br />'.\Environment::get('ip'),
	       'color'         => ($test02 == false) ? 'green' : 'red'
	    );
	    $arrDemo[] = array(
	       'type'          => 'agentadvanced',
	       'test'          => '03',
	       'theoretical'   => 'false',
	       'actual'        => var_export($test03,true),
	       'comment'       => '<br />'.\Environment::get('httpUserAgent'),
	       'color'         => ($test03 == false) ? 'green' : 'red'
	    );	    
	    $this->Template->demos = $arrDemo;
	    // get module version
	    $this->Template->version = $this->ModuleBotDetection->getVersion();
	}

}

?>