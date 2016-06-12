<?php
/**
 * Internationalization file for Memcached extension
 */

$messages = array();

/** English
 * @author UA2004
 */
$messages['en'] = array(
	'memcached' => 'Memcached',
	'memcached-desc' => 'Provides an interface for checking if Memcached is working fine',
	'memcached-data-received' => 'Test data got from Memcached successfully!',
	'memcached-data-set' => 'Test data written in Memcached! Please refresh the page to see if it is working properly.',
	'memcached-works' => 'Memcached seems to be working fine!',
	'memcached-not-working' => 'Memcached DOES NOT seem to be working! Please restart it.',
	'memcached-not-found' => 'Memcached is not available on this server!',
	'memcached-pecl-not-found' => 'Memcache PECL is not available on this server!',
	'memcached-servers-not-set' => 'Memcached servers not set! Please add them into <b>$wgMemCachedServers</b> setting in your LocalSettings.php file.',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'memcached' => 'Memcached',
	'memcached-desc' => 'Stellt ein Interface zur Überprüfung des Status von Memcached bereit',
	'memcached-data-received' => 'Die Testdaten wurden erfolgreich von Memcached abgerufen.',
	'memcached-data-set' => 'Die Testdaten wurden an Memcached übermittelt. Bitte den Seitencache leeren, um zu prüfen, ob Memcached problemlos funktioniert.',
	'memcached-works' => 'Memcached scheint problemlos zu funktionieren.',
	'memcached-not-working' => 'Memcached scheint nicht problemlos zu funktionieren und sollte neu gestartet werden.',
	'memcached-not-found' => 'Memcached ist nicht auf dem Server verfügbar.',
	'memcached-pecl-not-found' => 'Memcache PECL ist nicht auf dem Server verfügbar.',
	'memcached-servers-not-set' => 'Die Memcached-Sever wurden nicht für MediaWiki konfiguriert. Der Parameter <code>$wgMemCachedServers</code> muß noch zur Datei „LocalSettings.php“ hinzugefügt werden.',
);

/** Ukrainian (українська)
 * @author UA2004
 */
$messages['uk'] = array(
	'memcached' => 'Memcached',
	'memcached-desc' => 'Надає інтерфейс для перевірки роботи служби Memcached на сервері',
	'memcached-data-received' => 'Тестові дані успішно зчитано з Memcached!',
	'memcached-data-set' => 'Тестові дані записано у Memcached! Будь ласка, оновіть сторінку, щоб побачити чи служба працює належним чином.',
	'memcached-works' => 'Служба Memcached працює!',
	'memcached-not-working' => 'Служба Memcached НЕ працює! Перезапустіть її, будь ласка.',
	'memcached-not-found' => 'Службу Memcached не знайдено на цьому сервері!',
	'memcached-pecl-not-found' => 'Розширення PECL memcache не знайдено на цьому сервері!',
	'memcached-servers-not-set' => 'Сервери Memcached не вказано! Будь ласка, додайте їх у змінну <b>$wgMemCachedServers</b> у файлі LocalSettings.php.',
);

/** French
 * @author cybernaute
 */
$messages['fr'] = array(
        'memcached' => 'Memcached',
        'memcached-desc' => 'Fournit une interface pour vérifier le fonctionnement de Memcached',
        'memcached-data-received' => 'Données tests Memcached obtenues avec succès !',
        'memcached-data-set' => 'Données de test écrites dans Memcached ! Veuillez rafraîchir la page pour voir si le résultat est correct.',
        'memcached-works' => 'Memcached semble fonctionner correctement!',
        'memcached-not-working' => 'Memcached semble NE PAS fonctionner correctement ! Veuillez le redémarrrer.',
        'memcached-not-found' => 'Memcached est indisponible sur ce serveur !',
        'memcached-pecl-not-found' => 'Memcache PECL est indisponible sur ce serveur !',
        'memcached-servers-not-set' => 'Les serveurs Memcached ne sont pas encore configureées ! Veuillez les ajouter en utilisant le paramètre <b>$wgMemCachedServers</b> dans votre fichier LocalSettings.php.',
);
