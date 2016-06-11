<?php
# This file was automatically generated by the MediaWiki 1.26.2
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

$wgShowExceptionDetails = getenv('SHOW_EXCEPTIONS');

## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = getenv('SITE_NAME');
$wgMetaNamespace = getenv('SITE_META_NAME');

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "";

## The protocol and server name to use in fully-qualified URLs
$wgServer = getenv('SITE_SERVER');


## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = getenv('SITE_LOGO_URL');

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = getenv('ADMIN_EMAIL');
$wgPasswordSender = getenv('ADMIN_EMAIL');

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = true; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "postgres";
$wgDBserver = getenv('DATABASE_SERVER');
$wgDBname = getenv('DATABASE_NAME');
$wgDBuser = getenv('DATABASE_USER');
$wgDBpassword = getenv('DATABASE_PASSWORD');

# Postgres specific settings
$wgDBport = "5432";
$wgDBmwschema = "mediawiki";

## Shared memory settings
$wgMainCacheType = CACHE_ACCEL;

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = true;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "en_US.utf8";

## If you want to use image uploads under safe mode,
## create the directories images/archive, images/thumb and
## images/temp, and make them all writable. Then uncomment
## this, if it's not already uncommented:
#$wgHashedUploadDirectory = false;

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
#$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/Names.php
$wgLanguageCode = "en";

$wgSecretKey = getenv('MEDIAWIKI_SECRET_KEY');

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = getenv('MEDIAWIKI_UPGRADE_KEY');

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "https://creativecommons.org/licenses/by-sa/3.0/";
$wgRightsText = "Creative Commons Attribution-ShareAlike";
$wgRightsIcon = "$wgResourceBasePath/resources/assets/licenses/cc-by-sa.png";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

# The following permissions were set based on your choice in the installer
$wgGroupPermissions['*']['createaccount'] = false;
$wgGroupPermissions['*']['edit'] = false;

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin( 'CologneBlue' );
wfLoadSkin( 'Modern' );
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'Vector' );


# Enabled Extensions. Most extensions are enabled by including the base extension file here
# but check specific extension documentation for more details
# The following extensions were automatically enabled:
wfLoadExtension( 'Cite' );
wfLoadExtension( 'CiteThisPage' );
wfLoadExtension( 'ConfirmEdit' );
wfLoadExtension( 'Gadgets' );
wfLoadExtension( 'ImageMap' );
wfLoadExtension( 'InputBox' );
wfLoadExtension( 'ParserFunctions' );
wfLoadExtension( 'PdfHandler' );
wfLoadExtension( 'Renameuser' );
wfLoadExtension( 'SpamBlacklist' );
wfLoadExtension( 'TitleBlacklist' );
wfLoadExtension( 'WikiEditor' );
wfLoadExtension( 'EmbedVideo' );
wfLoadExtension( 'UniversalLanguageSelector' );
wfLoadExtension( 'ContributionTracking' );
wfLoadExtension( 'DonationInterface' );
wfLoadExtension( 'PayPal' );


# End of automatically generated settings.
# Add more configuration options below.

# Use sendgrid to send email
require_once 'Mail.php';

//Email
// $wgSMTP = array(
//  'host'     => "smtp.postmarkapp.com", 						// could also be an IP address. Where the SMTP server is located
//  'IDHost'   => "lathe-tools.herokuapp.com",				// Generally this will be the domain name of your website (aka mywiki.org)
//  'port'     => 25,																// Port to use when connecting to the SMTP server
//  'auth'     => true,															// Should we use SMTP authentication (true or false)
//  'username' => getenv('POSTMARK_API_TOKEN'),			// Username to use for SMTP authentication (if being used)
//  'password' => getenv('POSTMARK_API_TOKEN')				// Password to use for SMTP authentication (if being used)
// );
$wgSMTP = array(
	'host' => 'smtp.sendgrid.net',
	'username' => getenv("SENDGRID_USERNAME"),
	'password' => getenv("SENDGRID_PASSWORD"),
	'IDHost' => 'heroku.com',
	'port' => '587',
	'auth' => true
);

// $wgUploadDirectory is the directory in your bucket where the image directories and images will be stored.
// If "images" doesn't work for you, change it.
$wgUploadDirectory = getenv('UPLOAD_DIRECTORY');
$wgUploadS3Bucket = getenv('S3_BUCKET_NAME');
$wgUploadS3SSL = false; // true if SSL should be used
$wgPublicS3 = true; // true if public, false if authentication should be used

$wgS3BaseUrl = "http".($wgUploadS3SSL?"s":"")."://s3.amazonaws.com/$wgUploadS3Bucket";

//viewing needs a different url from uploading. Uploading doesnt work on the below url and viewing doesnt work on the above one.
$wgS3BaseUrlView = "http".($wgUploadS3SSL?"s":"")."://".$wgUploadS3Bucket.".s3.amazonaws.com";
$wgUploadBaseUrl = "$wgS3BaseUrlView/$wgUploadDirectory";

// leave $wgCloudFrontUrl blank to not render images from CloudFront
$wgCloudFrontUrl = "http".($wgUploadS3SSL?"s":"").'://'.getenv('CLOUDFRONT_SUBDOMAIN').'.cloudfront.net/';
$wgLocalFileRepo = array(
	'class' => 'LocalS3Repo',
	'name' => 's3',
	'directory' => $wgUploadDirectory,
	'url' => $wgUploadBaseUrl ? $wgUploadBaseUrl . $wgUploadPath : $wgUploadPath,
	'urlbase' => $wgS3BaseUrl ? $wgS3BaseUrl : "",
	'hashLevels' => $wgHashedUploadDirectory ? 2 : 0,
	'thumbScriptUrl' => $wgThumbnailScriptPath,
	'transformVia404' => !$wgGenerateThumbnailOnParse,
	'initialCapital' => $wgCapitalLinks,
	'deletedDir' => $wgUploadDirectory.'/deleted',
	'deletedHashLevels' => $wgFileStore['deleted']['hash'],
	'AWS_ACCESS_KEY' => getenv('AWS_ACCESS_KEY_ID'),
	'AWS_SECRET_KEY' => getenv('AWS_SECRET_KEY'),
	'AWS_S3_BUCKET' => $wgUploadS3Bucket,
	'AWS_S3_PUBLIC' => $wgPublicS3,
	'AWS_S3_SSL' => $wgUploadS3SSL,
	'cloudFrontUrl' => $wgCloudFrontUrl
);
require_once("$IP/extensions/LocalS3Repo/LocalS3Repo.php");

// s3 filesystem repo - end

//HTMLets
require_once("$IP/extensions/HTMLets/HTMLets.php");
$wgHTMLetsDirectory = "$IP/htmlets";

//FontAwesome
require_once("$IP/extensions/FontAwesome/FontAwesome.php");

//Upload Wizard
//https://www.mediawiki.org/wiki/Extension:UploadWizard
// require_once( "$IP/extensions/UploadWizard/UploadWizard.php" );
// $wgUploadNavigationUrl = '/wiki/Special:UploadWizard';
// $wgExtensionFunctions[] = function() {
// 	$GLOBALS['wgUploadNavigationUrl'] = SpecialPage::getTitleFor( 'UploadWizard' )->getLocalURL();
// 	return true;
// };
// $wgApiFrameOptions = 'SAMEORIGIN';
// $wgAllowCopyUploads = true;
// $wgGroupPermissions['user']['upload_by_url'] = true; // to allow for all registered users
// $wgUploadWizardConfig = array(
// 	'flickrApiUrl' => getenv('FLICKR_API_URL'),
// 	'flickrApiKey' => getenv('FLICKR_API_KEY')
// );

//Social Sharing
//https://www.mediawiki.org/wiki/Extension:AddThis
require_once "$IP/extensions/AddThis/AddThis.php";
$wgAddThisHeader = true;
$wgAddThispubid = getenv('ADD_THIS_KEY');

//Fancy thumbs
require_once("$IP/extensions/FancyBoxThumbs/FancyBoxThumbs.php");
//$fbtFancyBoxOptions = '{"openEffect":"elastic","closeEffect":"elastic","helpers":{"title":{"type":"inside"}}}';

require_once("$IP/extensions/EmbedVideo/EmbedVideo.php");

require_once("$IP/extensions/UniversalLanguageSelector/UniversalLanguageSelector.php");

require_once("$IP/extensions/ContributionTracking/ContributionTracking.php");

# https://www.mediawiki.org/wiki/Extension:DonationInterface
require_once("$IP/extensions/DonationInterface/DonationInterface.php");

$wgDonationInterfaceEnableAmazon = true;

# https://www.mediawiki.org/wiki/Extension:PayPal
require_once("$IP/extensions/PayPal/PayPal.php");

# Semantic MediaWiki Requirements
enableSemantics( getenv('SITE_URL') );
