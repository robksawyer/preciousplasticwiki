<?php
if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'ContributionTracking' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['ContributionTracking'] = __DIR__ . '/i18n';
	$wgExtensionMessagesFiles['ContributionTracking'] = __DIR__ . '/ContributionTracking.alias.php';
	/* wfWarn(
		'Deprecated PHP entry point used for ContributionTracking extension. Please use wfLoadExtension instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	); */
	return;
}

/**
 * Setup for pre-1.25 wikis. Make sure this is kept in sync with extension.json
 */

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'ContributionTracking',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:ContributionTracking',
	'author'         => 'David Strauss',
	'descriptionmsg' => 'contributiontracking-desc',
);

$dir = __DIR__ . '/';

$wgMessagesDirs['ContributionTracking'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['ContributionTrackingAlias'] = $dir . 'ContributionTracking.alias.php';
$wgAutoloadClasses['ContributionTrackingHooks'] = $dir . 'ContributionTracking.hooks.php';
$wgAutoloadClasses['ContributionTracking'] = $dir . 'ContributionTracking_body.php';
$wgSpecialPages['ContributionTracking'] = 'ContributionTracking';

$wgAutoloadClasses['ContributionTrackingTester'] = $dir . 'ContributionTracking_Tester.php';
$wgSpecialPages['ContributionTrackingTester'] = 'ContributionTrackingTester';

$wgAutoloadClasses['SpecialFundraiserMaintenance'] = $dir . 'special/SpecialFundraiserMaintenance.php';
$wgSpecialPages['FundraiserMaintenance'] = 'SpecialFundraiserMaintenance';

//give sysops access to the tracking tester form.
$wgGroupPermissions['sysop']['ViewContributionTrackingTester'] = true;
$wgAvailableRights[] = 'ViewContributionTrackingTester';

$wgAutoloadClasses['ApiContributionTracking'] = $dir . 'ApiContributionTracking.php';
$wgAutoloadClasses['ContributionTrackingProcessor'] = $dir . 'ContributionTracking.processor.php';

//this only works if contribution tracking is inside a mediawiki DB, which typically it isn't.
$wgHooks['LoadExtensionSchemaUpdates'][] = 'ContributionTrackingHooks::onLoadExtensionSchemaUpdates';

// Resource modules
$ctResourceTemplate = array(
	'localBasePath' => $dir . 'modules',
	'remoteExtPath' => 'ContributionTracking/modules',
);
$wgResourceModules['jquery.contributionTracking'] = array(
	'scripts' => 'jquery.contributionTracking.js',
) + $ctResourceTemplate;

$wgResourceModules['contributionTracking.fundraiserMaintenance'] = array(
	'styles' => array('skinOverride.css',),
	'scripts' => array(),
	'position' => 'top',
) + $ctResourceTemplate;

/**
 * The default 'return to' URL for a thank you page after posting to the contribution
 *
 * NO trailing slash, please
 */
$wgContributionTrackingReturnToURLDefault = 'http://wikimediafoundation.org/wiki/Thank_You';

$wgContributionTrackingDBserver = $wgDBserver;
$wgContributionTrackingDBname = $wgDBname;
$wgContributionTrackingDBuser = $wgDBuser;
$wgContributionTrackingDBpassword = $wgDBpassword;

/**
 * IPN listener address for regular PayPal trxns
 */
$wgContributionTrackingPayPalIPN = 'https://civicrm.wikimedia.org/fundcore_gateway/paypal';

/**
 * IPN listener address for recurring payment PayPal trxns
 */
$wgContributionTrackingPayPalRecurringIPN = 'https://civicrm.wikimedia.org/fundcore_gateway/paypal';

/**
 * 'Business' string for PayPal
 */
$wgContributionTrackingPayPalBusiness = 'donations@wikimedia.org';

/**
 * Recurring PayPal subscription Length. Default of 0 is unlimited until canceled
 */

$wgContributionTrackingRPPLength = '0';

/**
 * Shows a scheduled maintenance notification instead of the interstitial page
 */
$wgContributionTrackingFundraiserMaintenance = false;

/**
 * Shows an unscheduled maintenance notification instead of the interstitial page
 */
$wgContributionTrackingFundraiserMaintenanceUnsched = false;

// api modules
$wgAPIModules['contributiontracking'] = 'ApiContributionTracking';
