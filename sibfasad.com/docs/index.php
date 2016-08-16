<?php
/*
* @debug
*/
// ini_set('display_errors', 'on');
// ini_set('display_startup_errors', 'on');
// error_reporting(E_ALL);
error_reporting(0);

/*
* Start sesson
*/
ini_set('session.cookie_lifetime', 365 * 86400);
ini_set('session.gc_maxlifetime',  365 * 86400);
session_start();

/*
* Define paths
*/
if (__DIR__ !== '') {
    define('ROOT_PATH', __DIR__);
} else {
    define('ROOT_PATH', dirname(__FILE__));
}
define('CONTROLLERS_PATH', ROOT_PATH . '/controllers');
define('TEMPLATES_PATH', ROOT_PATH . '/templates');
define('UPLOADS_PATH', ROOT_PATH . '/upload');
define('PROJECT_DIR', realpath('./'));
define('LOCALE_DIR', PROJECT_DIR .'/locale');
define('DEFAULT_VERSION', 'ru');
require_once(PROJECT_DIR.'/libs/gettext/gettext.inc');

$uriTokens = array_filter(explode('/', $_SERVER['REQUEST_URI']));
$supported_versions = array(
    'ru' => ['locale' => 'ru_RU', 'db' => 'sibfasad_db'],
    'de' => ['locale' => 'de_DE', 'db' => 'sibfasad_db_de']
);
$version = DEFAULT_VERSION;
$param1 = array_shift($uriTokens);

if(in_array($param1, array_keys($supported_versions))){
    $version = $param1;
    $controllerName = array_shift($uriTokens);
}
else $controllerName = $param1;
T_setlocale(LC_MESSAGES, $supported_versions[$version]['locale']);
/*
* Connect to database
*/
// Database config
/*$dbConfig = [
    'host' => '79.174.71.59',
    'user' => 'm157y_sf',
    'pass' => 'SYaT6qGYR3YNtsBN',
    'db'   => 'm157y_sf',
];*/
/*$dbConfig = [
    'host' => 'sibfasad.mysql',
    'user' => 'sibfasad_mysql',
    'pass' => '+oTSk8DN',
    'db'   => 'sibfasad_db',
];*/
$dbConfig = [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'db'   => $supported_versions[$version]['db'],
];
// Connect to database
$dbLink = mysqli_connect(
    $dbConfig['host'],
    $dbConfig['user'],
    $dbConfig['pass'],
    $dbConfig['db']
);

// Oops error is here
if ($dbLink === false) {
    echo 'Could not connect to database.';
    exit;
}

// Set encoding
mysqli_query($dbLink, 'SET NAMES utf8');

// Close database connection on exit
register_shutdown_function(function() use ($dbLink) {
    mysqli_close($dbLink);
});

/*
* Initialize smarty
*/
require(ROOT_PATH . '/smarty/Smarty.class.php');
$template = new Smarty();
$template->setTemplateDir(TEMPLATES_PATH);
$template->addPluginsDir(ROOT_PATH . '/smarty/custom_plugins/');
if($version != DEFAULT_VERSION)
$template->assign('version', $version);
/*
* Router O_o
*/

// Parse URI

// Catch controller options
//$controllerName = array_shift($uriTokens);
$controllerAction = array_shift($uriTokens);

// Set default controller name and action if need
if ($controllerName === null) {
    $controllerName = 'index';
}
if ($controllerAction === null) {
    $controllerAction = 'index';
}

// Prevent possible attacks
if (strpos($controllerName, '..') !== false) {
    die('Hacking attempt!');
}

// Check that controller exists
if (file_exists(CONTROLLERS_PATH . '/' . $controllerName . '.php') === false) {
    $controllerName = 'error';
    $controllerAction = '404';
}

// Load controller
require(CONTROLLERS_PATH . '/skeleton.php');
require(CONTROLLERS_PATH . '/' . $controllerName . '.php');
$controllerClass = '\\Controllers\\' . $controllerName;
$controllerObject = new $controllerClass;
$controllerObject->setTemplateObject($template);

// Call specified action
call_user_func([$controllerObject, 'action' . $controllerAction], $uriTokens);

// Output
$controllerObject->sendHeaders();
$controllerObject->display();
