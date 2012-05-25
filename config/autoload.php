<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Botdetection
 * @link    http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'BugBuster\BotDetection',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Botdetection
	'BugBuster\BotDetection\ModuleBotDetection'     => 'system/modules/botdetection/ModuleBotDetection.php',
	'BugBuster\BotDetection\ModuleFrontendDemo1'    => 'system/modules/botdetection/ModuleFrontendDemo1.php',
	'BugBuster\BotDetection\ModuleFrontendDemo2'    => 'system/modules/botdetection/ModuleFrontendDemo2.php',

	// Test
	'BugBuster\BotDetection\ModuleBotDetectionTest' => 'system/modules/botdetection/test/ModuleBotDetectionTest.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_botdetection_demo1_fe' => 'system/modules/botdetection/templates',
	'mod_botdetection_demo2_fe' => 'system/modules/botdetection/templates',
));
