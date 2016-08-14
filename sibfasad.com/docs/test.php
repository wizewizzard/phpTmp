<?php
define('PROJECT_DIR', realpath('./'));
define('LOCALE_DIR', PROJECT_DIR .'/locale');
define('DEFAULT_LOCALE', 'ru_RU');

require_once(PROJECT_DIR.'/libs/gettext/gettext.inc');
$supported_locales = array('ru_RU', 'de_DE');
$encoding = 'UTF-8';

//$locale = (isset($_GET['lang']))? $_GET['lang'] : DEFAULT_LOCALE;
$locale = 'de_DE';
// gettext setup
T_setlocale(LC_MESSAGES, $locale);
// Set the text domain as 'messages'
$domain = 'messages';
T_bindtextdomain($domain, LOCALE_DIR);
T_bind_textdomain_codeset($domain, $encoding);
T_textdomain($domain);


$text = T_gettext("Объекты");
echo $text;