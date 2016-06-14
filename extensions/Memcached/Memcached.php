<?php
/**
 * A Memcached extension for MediaWiki
 * Originally written for ZeWiki
 * Provides an interface for checking if memcached is working fine
 *
 * @link https://www.mediawiki.org/wiki/Extension:Memcached Documentation
 * @link https://www.mediawiki.org/wiki/Extension_talk:Memcached Support
 *
 * @author UA2004 <ua2004 at ukr.net> for ZeWiki.com
 * @copyright Copyright (C) 2013, UA2004
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

define( 'Memcached_VERSION', '1.0.1' );

$wgExtensionCredits['specialpage'][] = array(
  'path'           => __FILE__,
	'name'           => 'Memcached',
	'author'         => 'UA2004',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Memcached',
	'version'        => Memcached_VERSION,
	'descriptionmsg' => 'memcached-desc',
	'license-name'   => 'GPL-2.0+',
);

$wgSpecialPages['Memcached'] = 'SpecialMemcached';
$wgExtensionMessagesFiles['Memcached'] = dirname(__FILE__) . '/Memcached.i18n.php';

$wgAvailableRights[] = 'memcached';
$wgGroupPermissions['*']['memcached'] = false;
$wgGroupPermissions['bureaucrat']['memcached'] = true;


class SpecialMemcached extends SpecialPage {
	const MEMC_OK = 1;
	const MEMC_ERROR = 0;
	const MEMC_NOT_FOUND = -1;

	public function __construct() {
		parent::__construct('Memcached');
	}

	public function execute($subPage) {
		global $wgOut, $wgRequest, $wgUser, $wgMemc, $wgMemCachedServers;

		wfProfileIn(__METHOD__);

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor('Memcached');

		if (!$wgUser->isAllowed( 'memcached' )) {
			$this->displayRestrictionError();
			wfProfileOut(__METHOD__);
			return;
		}

		if (class_exists('Memcache')) {
			if(empty($wgMemCachedServers)) {
				$wgOut->addHTML('<h3>'.wfMsg('memcached-servers-not-set').'</h3>');
			}
			else {
				$wgOut->addHTML(Xml::openElement('table', array('border'=>1)));
				foreach($wgMemCachedServers as $server) {
					switch($this->testMemcachedServer( $server )) {
						case self::MEMC_OK:
							$message = wfMsg('memcached-works');
							$color = '#84eb82';
							break;
						case self::MEMC_ERROR:
							$message = wfMsg('memcached-not-working');
							$color = '#ffde46';
							break;
						case self::MEMC_NOT_FOUND:
							$message = wfMsg('memcached-not-found');
							$color = '#fe7f7a';
							break;
					}
					$wgOut->addHTML(Xml::openElement('tr', array('style'=>'background-color:'.$color)));
					$wgOut->addHTML(Xml::openElement('td'));
					$wgOut->addHTML($server);
					$wgOut->addHTML(Xml::closeElement('td'));
					$wgOut->addHTML(Xml::openElement('td'));
					$wgOut->addHTML($message);
					$wgOut->addHTML(Xml::closeElement('td'));
					$wgOut->addHTML(Xml::closeElement('tr'));
				}
				$wgOut->addHTML(Xml::closeElement('table'));
			}
		}
		else {
			$wgOut->addHTML('<h3>'.wfMsg('memcached-pecl-not-found').'</h3>');
		}

		wfProfileOut(__METHOD__);
	}

	public function testMemcachedServer( $server ) {
		wfProfileIn(__METHOD__);

		$memcache = new Memcache;
		$isMemcacheAvailable = @$memcache->connect($server);

		if ($isMemcacheAvailable) {
			$key = wfMemcKey( 'zewiki', 'special', 'memcached', 'test' );
			$aData = $memcache->get($key);
			if ($aData) {
				return self::MEMC_OK;
			} else {
				$aData = array(
					'me' => 'you',
					'us' => 'them',
				);
				$memcache->set($key, $aData, 0, 300);
				$aData = $memcache->get($key);
				if ($aData) {
					return self::MEMC_OK;
				} else {
					return self::MEMC_ERROR;
				}
			}
		}
		else {
			return self::MEMC_NOT_FOUND;
		}

		wfProfileOut(__METHOD__);
	}

	protected function getGroupName() {
		return 'wiki';
	}
}
