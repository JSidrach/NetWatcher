<?php
/**
 * Model class of the captures
 *
 * Inherits from appModel class
 *
 * @package App
 */

/**
 * App namespace (user defined behaviour)
 */
namespace App;

/**
 * capturesModel class.
 * Stores the representation of the captures info
 */
class capturesModel extends Common\appModel
{
    /**
     * Refresh rate
     * 
     * @var Number of seconds between calls to get the data
     */
    public $refreshRate;
    
    /**
     * Constructor for the captures model
     */
    public function __construct()
    {
        /* Set the refresh rate (seconds) */
        $this->refreshRate = 5;
    }
}
?>