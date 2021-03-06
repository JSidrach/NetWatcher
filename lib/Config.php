<?php
/**
 * Configuration Class for storing and defining MVC constants
 *
 * Contains basic mvc configuration as well as definition the paths of common elements
 *
 * @package Core
 */

/**
 * Basic functionality classes
 */
namespace Core;

/**
 * Loads the configuration of the MVC
 */
class Config
{

    /**
     * Languages
     */
    public static $LANGUAGES;

    /**
     * User Themes
     */
    public static $CSS_THEMES;

    /**
     * Default CSS Theme
     */
    public static $DEFAULT_CSS_THEME;

    /**
     * Default Language
     */
    public static $DEFAULT_LANG;

    /**
     * Server IP
     */
    public static $REMOTE_SERVER_IP;

    /**
     * Time of the latest change to the settings (for cache purposes)
     */
    public static $CACHE_TIME;

    /**
     * Loads the configuration of the MVC
     *
     * @param BaseDir $baseDir
     *            Base directory
     */
    public static function load($baseDir = '.')
    {
        /* Display all the errors */
        error_reporting(- 1);
        ini_set('display_errors', 1);
        
        /* Custom exception handler */
        set_exception_handler('Core\Logger::logException');
        
        /* Custom error handler */
        set_error_handler('Core\Logger::logError');
        
        /* Starts the session */
        session_start();
        
        /**
         * Name of the app
         */
        define('APP_NAME', 'NetWatcher');
        
        /**
         * Number of indent spaces
         */
        define('INDENT_SPACES', 2);
        /**
         * Charset
         */
        define('META_CHARSET', 'utf-8');
        
        /**
         * Default controller
         */
        define('DEFAULT_CONTROLLER', 'manager');
        /**
         * Default method
         */
        define('DEFAULT_METHOD', 'display');
        
        /**
         * Define the target URL Parameter ID for proxy calls
         */
        define('PROXY_ID', 'url');
        
        /**
         * Base path for the proxy queries
         */
        define('PROXY_PATH', 'proxy.php?' . PROXY_ID . '=');
        
        /**
         * Routes
         */
        
        /**
         * Path to the base directory
         */
        define('BASE_DIR', $baseDir . DIRECTORY_SEPARATOR);
        
        /**
         * Path to the config directory
         */
        define('CONFIG_DIR', BASE_DIR . 'config' . DIRECTORY_SEPARATOR);
        /**
         * Path to the default config file
         */
        define('DEFAULT_CONFIG_FILE', CONFIG_DIR . 'settings.json');
        /**
         * Path to the languages list file
         */
        define('LANGUAGES_LIST_FILE', CONFIG_DIR . 'languages.json');
        
        /**
         * Path to the public directory
         */
        define('PUBLIC_DIR', BASE_DIR . 'public' . DIRECTORY_SEPARATOR);
        /**
         * Icon of the app
         */
        define('APP_FAVICON', PUBLIC_DIR . 'favicon.ico');
        /**
         * Path to the 404 Not Found page
         */
        define('ERROR_404', PUBLIC_DIR . '404.php');
        /**
         * Readme file
         */
        define('LICENSE_FILE', BASE_DIR . 'LICENSE.md');
        
        /**
         * Libraries
         */
        /**
         * Path to the javascript dir
         */
        define('JS_DIR', PUBLIC_DIR . 'js' . DIRECTORY_SEPARATOR);
        /**
         * Path to the css dir
         */
        define('CSS_DIR', PUBLIC_DIR . 'css' . DIRECTORY_SEPARATOR);
        /**
         * Path to the themes dir
         */
        define('THEMES_DIR', PUBLIC_DIR . 'themes' . DIRECTORY_SEPARATOR);
        /**
         * Path to the fonts dir
         */
        define('FONTS_DIR', PUBLIC_DIR . 'fonts' . DIRECTORY_SEPARATOR);
        /**
         * Path to the img dir
         */
        define('IMG_DIR', PUBLIC_DIR . 'img' . DIRECTORY_SEPARATOR);
        
        /**
         * Default folders and methods for the MVC pattern
         */
        
        /**
         * Path to the app directory
         */
        define('APP_DIR', BASE_DIR . 'app' . DIRECTORY_SEPARATOR);
        /**
         * Path to the modules dir
         */
        define('MODULES_DIR', APP_DIR . 'modules' . DIRECTORY_SEPARATOR);
        
        /**
         * Path to the documentation directory
         */
        define('DOC_DIR', 'docs' . DIRECTORY_SEPARATOR);
        
        /**
         * Path to the root of the documentation
         */
        define('FRONT_END_DOCS', DOC_DIR . 'front-end' . DIRECTORY_SEPARATOR . 'index.html');
        
        /**
         * Path to the root of the documentation
         */
        define('BACK_END_DOCS', DOC_DIR . 'back-end' . DIRECTORY_SEPARATOR . 'index.html');
        
        /**
         * Path to the localization directory
         */
        define('LOCALIZATION_DIR', BASE_DIR . 'locale' . DIRECTORY_SEPARATOR);
        
        /**
         * Path to the log folder
         */
        define('LOGGER_DIR', BASE_DIR . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR);
        /**
         * Path to the action log file
         */
        define('LOGGER_ACTION', LOGGER_DIR . 'action.log');
        /**
         * Path to the proxy log file
         */
        define('LOGGER_PROXY', LOGGER_DIR . 'proxy.log');
        /**
         * Path to the warning log file
         */
        define('LOGGER_WARNING', LOGGER_DIR . 'warning.log');
        /**
         * Path to the error log file
         */
        define('LOGGER_ERROR', LOGGER_DIR . 'error.log');
        /**
         * Path to the general log file
         */
        define('LOGGER_GENERAL', LOGGER_DIR . 'app.log');
        
        /* Loads the themes */
        self::loadThemes();
        
        /* Loads dynamic configuration */
        self::dynamicLoad();
    }

    /**
     * Loads the available themes
     */
    public static function loadThemes()
    {
        if ($handle = opendir(THEMES_DIR)) {
            while (false !== ($entry = readdir($handle))) {
                if (($entry != '.') && ($entry != '..')) {
                    $name = explode('.', $entry)[0];
                    self::$CSS_THEMES[ucfirst($name)] = $entry;
                }
            }
            asort(self::$CSS_THEMES);
            closedir($handle);
        } else {
            Logger::logWarning('Cannot open themes directory');
        }
    }

    /**
     * Loads the dynamic configuration from a file
     */
    public static function dynamicLoad()
    {
        /* Loads the configuration file */
        $configData = json_decode(file_get_contents(DEFAULT_CONFIG_FILE));
        
        /* Loads the languages */
        self::$LANGUAGES = json_decode(file_get_contents(LANGUAGES_LIST_FILE), true);
        
        /* Loads the css theme */
        self::$DEFAULT_CSS_THEME = $configData->theme;
        
        /* Loads the language */
        putenv('LANG=' . self::$LANGUAGES[$configData->lang]);
        putenv('LANGUAGE=' . self::$LANGUAGES[$configData->lang]);
        setlocale(LC_ALL, self::$LANGUAGES[$configData->lang]);
        /* Set the text domain as 'messages' */
        $domain = 'messages';
        bindtextdomain($domain, LOCALIZATION_DIR);
        bind_textdomain_codeset($domain, META_CHARSET);
        self::$DEFAULT_LANG = $configData->lang;
        
        /* Loads the server ip */
        self::$REMOTE_SERVER_IP = $configData->serverIp;
        
        /* Sets the cache time */
        self::$CACHE_TIME = $configData->cacheTime;
    }
}
?>