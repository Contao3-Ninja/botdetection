<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Modul BotDetection
 *
 * @copyright  Glen Langer 2007..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    BotDetection 
 * @license    LGPL 
 * @filesource
 * @see        https://github.com/BugBuster1701/botdetection
 */

/**
 * -------------------------------------------------------------------------
 * FRONT END MODULES
 * -------------------------------------------------------------------------
 *
 * List all fontend modules and their class names.
 * 
 *   $GLOBALS['FE_MOD'] = array
 *   (
 *       'group_1' => array
 *       (
 *           'module_1' => 'Contentlass',
 *           'module_2' => 'Contentlass'
 *       )
 *   );
 * 
 * Use function array_insert() to modify an existing CTE array.
 */
 
array_insert($GLOBALS['FE_MOD'], 4, array
(
    'BotDetectionDemo' => array
    (
	'botdetection1' => 'BotDetection\ModuleFrontendDemo1',
	'botdetection2' => 'BotDetection\ModuleFrontendDemo2',
	)
));
