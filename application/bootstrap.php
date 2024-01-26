<?php defined('SYSPATH') or die('No direct script access.');

if (strpos($_SERVER['REQUEST_URI'], '/song/view/') !== 0) {
        header('Location: http://slovovery.ru/24_7/song/', true, 301);
    exit;
    }

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH . 'classes/kohana/core' . EXT;

if (is_file(APPPATH . 'classes/kohana' . EXT)) {
	// Application extends the core
	require APPPATH . 'classes/kohana' . EXT;
} else {
	// Load empty core extension
	require SYSPATH . 'classes/kohana' . EXT;
}

//require_once APPPATH.'../vendor/autoload.php';

//require_once APPPATH.'classes/service/NewYaDisk.php';

require_once APPPATH.'classes/helper/SongsNameMatchingProvider.php';
require_once APPPATH.'classes/helper/SongsMatchingHelper.php';
require_once APPPATH.'classes/songs/FileSystemSongProvider.php';
require_once APPPATH.'classes/songs/ImportSong.php';
require_once APPPATH.'classes/songs/class_import_songs.php';
require_once APPPATH . 'classes/service/WebdavClient.php';
require_once APPPATH . 'classes/service/YandexDisk.php';
require_once APPPATH . 'classes/config/YandexDiskConfig.php';
require_once APPPATH . 'classes/builder/YandexDiskFilesListBuilder.php';
require_once APPPATH . 'classes/service/JobService.php';
require_once APPPATH . 'classes/helper/ImportYandexFilesHelper.php';
require_once APPPATH . 'classes/builder/YandexDiskBuilder.php';

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Europe/Moscow');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'ru_RU.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('ru-ru');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
/*if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}*/
Kohana::$environment = 'DEVELOPMENT';
//Kohana::$environment = 'DEVELOPMENT';
/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'base_url' => '/',
	'index_file' => false,
	'errors' => true,
));

ini_set('display_errors', true);

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH . 'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

Cookie::$salt = '123456654123';

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'auth' => MODPATH . 'auth',       // Basic authentication
	//'cache'      => MODPATH.'cache',      // Caching with multiple backends
	//'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	'database' => MODPATH . 'database',   // Database access
	'image' => MODPATH . 'image',      // Image manipulation
	'orm' => MODPATH . 'orm',        // Object Relationship Mapping
	//'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	'pagination' => MODPATH . 'pagination',
	'email' => MODPATH . 'email',
	'captcha' => MODPATH . 'captcha',
));

Route::set('error', 'error/<action>(/<message>)', array('action' => '[0-9]++', 'message' => '.+'))
	->defaults(array(
		'controller' => 'error'
	));

$pages_alts = implode('|', ORM::factory('page')->find_all()->as_array('id', 'alt_name'));

Route::set('page', '<alt_name>', array('alt_name' => '(' . $pages_alts . ')',))
	->defaults(array(
		'controller' => 'page',
		'action' => 'byalt',
	));

Route::set('comment', 'comment/<action>/<id>(/<model>)')
	->defaults(array(
		'controller' => 'comment',
		'action' => 'index',
	));

Route::set('user', 'user/loginza/<r_model>/<r_action>/<r_id>')
	->defaults(array(
		'controller' => 'user',
		'action' => 'loginza',
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
Route::set('default', '(<controller>(/<action>(/<id>(/<parent_id>))))')
	->defaults(array(
		'controller' => 'page',
		'action' => 'index',
	));
