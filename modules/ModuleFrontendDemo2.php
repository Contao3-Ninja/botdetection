<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Modul BotDetection - Frontend Demo
 * 
 * @copyright  Glen Langer 2007..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetectionDemo 
 * @license    LGPL 
 * @filesource
 * @see        https://github.com/BugBuster1701/botdetection 
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\BotDetection;

/**
 * Class ModuleFrontendDemo2
 * Use ModuleBotDetection with import function
 *
 * @copyright  Glen Langer 2007..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetectionDemo
 */
class ModuleFrontendDemo2 extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_botdetection_demo2_fe';
	
	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### Bot Detection Frontend Demo 2 ###';
			
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
        $this->ModuleBotDetection = new \BotDetection\ModuleBotDetection();
        
	    $arrFields = array();
	    $arrFields['agent_name'] = array
		(
			'name' => 'agent_name',
			'label' => $GLOBALS['TL_LANG']['MSC']['botdetectiondemo2_agent'],
			'inputType' => 'text',
			'eval' => array('mandatory'=>true, 'maxlength'=>256, 'decodeEntities'=>true)
		);
		$arrFields['agent_captcha'] = array
		(
			'name' => 'agent_captcha',
			'label' => $GLOBALS['TL_LANG']['MSC']['botdetectiondemo2_captcha'],
			'inputType' => 'captcha',
			'eval' => array('mandatory'=>true)
		);
	    
		$doNotSubmit = false;
		$arrWidgets = array();
		// Initialize widgets
		foreach ($arrFields as $arrField)
		{
			$strClass = $GLOBALS['TL_FFL'][$arrField['inputType']];

			// Continue if the class is not defined
			if (!$this->classFileExists($strClass))
			{
				continue;
			}

			$arrField['eval']['required'] = $arrField['eval']['mandatory'];
			$objWidget = new $strClass($this->prepareForWidget($arrField, $arrField['name'], $arrField['value']));

			// Validate widget
			if ($this->Input->post('FORM_SUBMIT') == 'botdetectiondemo2')
			{
				$objWidget->validate();

				if ($objWidget->hasErrors())
				{
					$doNotSubmit = true;
				}
			}

			$arrWidgets[] = $objWidget;
		}
	    $this->Template->fields = $arrWidgets;
	    
   		$this->Template->submit = $GLOBALS['TL_LANG']['MSC']['botdetectiondemo2_submit'];
		$this->Template->action = ampersand(\Environment::get('request'));

	    if ($this->Input->post('FORM_SUBMIT') == 'botdetectiondemo2' && !$doNotSubmit)
		{
			$arrSet = array
			(
				'agent_name'		=> \Input::post('agent_name')
			);
			
			// start tests

	        //Call BD_CheckBotAgent
    	    $test01 = $this->ModuleBotDetection->BD_CheckBotAgent($arrSet['agent_name']); 
    	    //Call BD_CheckBotAgentAdvanced
    	    $test02 = $this->ModuleBotDetection->BD_CheckBotAgentAdvanced($arrSet['agent_name']); 
    	    $not1 = ($test01) ? "<span style=\"color:green;\">".$GLOBALS['TL_LANG']['MSC']['botdetectiondemo2_found']."</span>" : "<span style=\"color:red;\">".$GLOBALS['TL_LANG']['MSC']['botdetectiondemo2_not']."</span>";
    	    $not2 = ($test02) ? "<span style=\"color:green;\">".$GLOBALS['TL_LANG']['MSC']['botdetectiondemo2_found']."</span>" : "<span style=\"color:red;\">".$GLOBALS['TL_LANG']['MSC']['botdetectiondemo2_not']."</span>";
    	    $not3 = ($test02) ? " (".$test02.")" : "";
    	    $messages  = "<strong>".$GLOBALS['TL_LANG']['MSC']['botdetectiondemo2_message_1'].":</strong><br />".$arrSet['agent_name']."<br /><br />";
    	    $messages .= "<div style=\"font-weight:bold; width:190px;float:left;\">CheckBotAgent:</div> ".$not1."<br />";
    	    $messages .= "<div style=\"font-weight:bold; width:190px;float:left;\">CheckBotAgentAdvanced:</div> ".$not2.$not3."<br />";
    	    
			$this->Template->message  = $messages;
			
			$arrWidgets = array();
			foreach ($arrFields as $arrField)
			{
				$strClass = $GLOBALS['TL_FFL'][$arrField['inputType']];
				// Continue if the class is not defined
				if (!$this->classFileExists($strClass))
				{
					continue;
				}
				$arrField['eval']['required'] = $arrField['eval']['mandatory'];
				$objWidget = new $strClass($this->prepareForWidget($arrField, $arrField['name'], $arrField['value']));
				$arrWidgets[] = $objWidget;
			}

			$this->Template->fields = $arrWidgets;
			
		}
	    // get module version
	    $this->Template->version = $this->ModuleBotDetection->getVersion();
	}

}
