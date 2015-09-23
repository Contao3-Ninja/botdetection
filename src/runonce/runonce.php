<?php   
/**
 * Contao Open Source CMS, Copyright (C) 2005-2015 Leo Feyer
 *
 * Modul BotDetection - /config/runonce.php
 *
 * PHP version 5
 * @copyright  Glen Langer 2007..2015
 * @author     Glen Langer
 * @package    BotDetection
 * @license    LGPL
 */
namespace BugBuster\BotDetection;
/**
 * Class BotDetectionRunonceJob
 *
 * @copyright  Glen Langer 2015
 * @author     Glen Langer
 * @package    Banner
 * @license    LGPL
 */
class BotDetectionRunonceJob extends \Controller
{
	public function __construct()
	{
	    parent::__construct();
	}

	public function run()
	{
	    CheckBotAgentExtended::checkAgent('Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3');
	}
}

$objBotDetectionRunonceJob = new BotDetectionRunonceJob();
$objBotDetectionRunonceJob->run();
