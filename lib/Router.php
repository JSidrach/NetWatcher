<?php
/**
 * Router class for managing URLs and creating the MVC objects
 *
 * Routes the request and invokes the appropiate objects of MVC with its methods
 *
 * @package Core
 */

/**
 * Basic functionality classes
 */
namespace Core;

/**
 * Router class for managing URLs and creating the MVC objects
 */
class Router
{

    /**
     * Parses the server request and builds the MVC objects
     *
     * The URL must have the form: ./page/method/arg1/arg2/arg3/...
     *
     * The controller's method must have only one param in its declaration (an array)
     */
    public static function dispatch()
    {
        
        /* Split the URL */
        $uri = parse_url($_SERVER['QUERY_STRING'], PHP_URL_PATH);
        $uri = trim($uri, ' /');
        $parts = explode('/', $uri);
        
        /**
         * Number of subparts of the URL
         */
        define('RELATIVE_SUBPATHS', count($parts));
        
        /* Loads the config */
        Config::load();
        
        /* Find the controller, method and arguments */
        $classname = $uri !== '' && isset($parts[0]) ? $parts[0] : DEFAULT_CONTROLLER;
        $classname = strtolower($classname);
        $method = $uri !== '' && isset($parts[1]) ? $parts[1] : DEFAULT_METHOD;
        $args = is_array($parts) && count($parts) > 2 ? array_slice($parts, 2) : array();
        
        /* If the requested controller is the documentation, charge it */
        if ($classname == 'documentation') {
            header('Location: ' . DOC_API);
            die();
        }
        
        /* Checks if the controller exist */
        if (! self::checkMVC($classname)) {
            /* Not Found: Error 404 */
            require (ERROR_404);
            return;
        }
        
        /* Loads the MVC objects */
        $model = '\App\\' . $classname . 'Model';
        $view = '\App\\' . $classname . 'View';
        $controller = '\App\\' . $classname . 'Controller';
        $m = new $model();
        $v = new $view($m);
        $c = new $controller($m, $v);
        
        /* Calls the method */
        if (method_exists($c, $method)) {
            Logger::logAction('Calling ' . $controller . '->' . $method . '(' . rtrim(implode(',', $args), ',') . ')');
            $c->$method($args);
            return;
        } else {
            Logger::logWarning('Method ' . $method . ' of ' . $controller . ' not found');
            require (ERROR_404);
            return;
        }
    }

    /**
     * Checks if the Model/View/Controller exists for a classname, then loads the MVC classes definitions from its files
     *
     * @param string $classname
     *            Name of the class to check
     * @return boolean true if the files exist, false otherwise
     */
    private static function checkMVC($classname)
    {
        /* Check each file */
        $commonPath = MODULES_DIR. $classname . DIRECTORY_SEPARATOR . $classname;
        $controller_file = $commonPath . 'Controller.php';
        if (! file_exists($controller_file)) {
            Logger::logWarning('File ' . $controller_file . ' not found');
            return false;
        }
        $view_file = $commonPath . 'View.php';
        if (! file_exists($view_file)) {
            Logger::logWarning('File ' . $view_file . ' not found');
            return false;
        }
        $model_file = $commonPath . 'Model.php';
        if (! file_exists($model_file)) {
            Logger::logWarning('File ' . $model_file . ' not found');
            return false;
        }
        /* Load the classes */
        require_once ($controller_file);
        require_once ($model_file);
        require_once ($view_file);
        
        return true;
    }
}
?>