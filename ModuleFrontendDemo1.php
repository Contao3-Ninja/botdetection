<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');
/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Glen Langer 2011 
 * @author     BugBuster 
 * @package    BotDetectionDemo 
 * @license    LGPL 
 * @filesource
 */


/**
 * Class ModuleFrontendDemo1
 * Use ModuleBotDetection with import function
 *
 * @copyright  Glen Langer 2007..2011
 * @author     Glen Langer 
 * @package    BotDetectionDemo
 */
class ModuleFrontendDemo1 extends Module
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
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### Bot Detection Frontend Demo 1 ###';
			
			$objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            if (version_compare(VERSION . '.' . BUILD, '2.8.9', '>'))
			{
			   // Code für Versionen ab 2.9.0
			   $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
			}
			else
			{
			   // Code für Versionen < 2.9.0
			   $objTemplate->href = 'typolight/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;
			}

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
	    $this->import('ModuleBotDetection');
	    
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
	       'comment'       => '<br />'.$this->Environment->httpUserAgent,
	       'color'         => ($test01 == false) ? 'green' : 'red'
	    );
	    $arrDemo[] = array(
	       'type'          => 'ip',
	       'test'          => '02',
	       'theoretical'   => 'false',
	       'actual'        => var_export($test02,true),
	       'comment'       => '<br />'.$this->Environment->ip,
	       'color'         => ($test02 == false) ? 'green' : 'red'
	    );
	    $arrDemo[] = array(
	       'type'          => 'agentadvanced',
	       'test'          => '03',
	       'theoretical'   => 'false',
	       'actual'        => var_export($test03,true),
	       'comment'       => '<br />'.$this->Environment->httpUserAgent,
	       'color'         => ($test03 == false) ? 'green' : 'red'
	    );	    
	    $this->Template->demos = $arrDemo;
	    // get module version
	    $this->Template->version = $this->ModuleBotDetection->getVersion();
	}

}

?>