<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @link http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 *
 * PHP version 5
 * @copyright  Glen Langer 2011 
 * @author     BugBuster 
 * @package    BotDetection 
 * @license    LGPL 
 * @filesource
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


?>