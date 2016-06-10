<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'FontAwesome',
	'author' => array(
		'[https://www.mediawiki.org/wiki/User:SwiftSys Lee Miller] | [https://www.mediawiki.org/wiki/Extension_talk:FontAwesome Support Contact]',
	),
	'descriptionmsg' => 'fontawesome-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:FontAwesome',
);

$wgExtensionMessagesFiles['FontAwesome'] = __DIR__ . '/FontAwesome.i18n.php';

$wgResourceModules['ext.FontAwesome'] = array(
	'styles' => array('font-awesome/css/font-awesome.min.css'),
	
		'dependencies' => array(
		'jquery.ui.mouse',
		'jquery.ui.slider',
		'jquery.ui.tabs',
	),
 
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'FontAwesome',
	
);