<?php
/**
 * Contao Open Source CMS, Copyright (C) 2005-2015 Leo Feyer
*
* Modul BotDetection - runonce
*
* PHP version 5
* @copyright  Glen Langer 2007..2015
* @author     Glen Langer
* @package    BotDetection
* @license    LGPL
*/
namespace BugBuster\BotDetection;

/**
 * Class BotDetectionRunonceJobDel6006
 *
 * @copyright  Glen Langer 2015
 * @author     Glen Langer
 * @package    Banner
 * @license    LGPL
 */
class BotDetectionRunonceJobDel6006 extends \Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function run()
    {
        // delete old cache/largebrowscap_v6006_1.0.4/ directory
        if (is_dir(TL_ROOT . '/system/modules/botdetection/cache/largebrowscap_v6006_1.0.4'))
        {
            $folder = new \Folder('system/modules/botdetection/cache/largebrowscap_v6006_1.0.4');
            if (!$folder->isEmpty())
            {
                $folder->purge();
            }
            $folder->delete();
            $folder=null;
            unset($folder);
        }
    }
}

$objBotDetectionRunonceJobDel6006 = new BotDetectionRunonceJobDel6006();
$objBotDetectionRunonceJobDel6006->run();
