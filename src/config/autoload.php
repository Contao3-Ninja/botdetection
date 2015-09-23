<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'BugBuster',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'BugBuster\BotDetection\ModuleBotDetection'    => 'system/modules/botdetection/modules/ModuleBotDetection.php',
	'BugBuster\BotDetection\ModuleBrowscapCache'   => 'system/modules/botdetection/modules/ModuleBrowscapCache.php',
	'BugBuster\BotDetection\ModuleFrontendDemo1'    => 'system/modules/botdetection/modules/ModuleFrontendDemo1.php',
	'BugBuster\BotDetection\ModuleFrontendDemo2'    => 'system/modules/botdetection/modules/ModuleFrontendDemo2.php',

	// Classes
	'BugBuster\BotDetection\CheckBotAgentExtended' => 'system/modules/botdetection/classes/CheckBotAgentExtended.php',
	'BugBuster\BotDetection\CheckBotAgentSimple'   => 'system/modules/botdetection/classes/CheckBotAgentSimple.php',
	'BugBuster\BotDetection\BrowscapCache'         => 'system/modules/botdetection/classes/BrowscapCache.php',
	'BugBuster\BotDetection\CheckBotReferrer'      => 'system/modules/botdetection/classes/CheckBotReferrer.php',
	'BugBuster\BotDetection\CheckBotIp'            => 'system/modules/botdetection/classes/CheckBotIp.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_botdetection_browscap_fe' => 'system/modules/botdetection/templates',
	'mod_botdetection_demo2_fe'    => 'system/modules/botdetection/templates',
	'mod_botdetection_demo1_fe'    => 'system/modules/botdetection/templates',
));
