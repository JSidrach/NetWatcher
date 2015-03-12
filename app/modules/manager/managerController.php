<?php
/**
 * Controller class of the manager
 *
 * Inherits from appController class
 *
 * @package App
 */

/**
 * App namespace (user defined behaviour)
 */
namespace App;

/**
 * managerController class.
 * Manages the fpga as a finite state machine
 */
class managerController extends Common\appController
{

    /**
     * Callbacks depending on the model status
     */
    private $subPages = array(
        'error' => 'renderError',
        'hugepages_off' => 'renderErrorHP',
        'init_off' => 'renderModeSelection',
        'mount_off' => 'renderModeSelection',
        'recorder_ready' => 'renderRecorderForm',
        'recording' => 'renderRecording'
    );

    /**
     * Default inherited constructor for the managerController class
     *
     * @param ManagerModel $model
     *            Data model of the Manager page
     * @param ManagerView $view
     *            View representation of the Manager page
     */
    public function __construct(ManagerModel $model, ManagerView $view)
    {
        parent::__construct($model, $view);
    }

    /**
     * Overwrites the parent display to control the different pages depending on the FPGA status
     *
     * @see \App\Common\Controllers\appController::display()
     *
     * @param array $args
     *            Params of the display (unused)
     */
    public function display(Array $args)
    {
        $action = $this->model->getManagerStatus()->status;
        
        if (isset($this->subPages[$action]) && method_exists($this->view, $this->subPages[$action])) {
            $callback = $this->subPages[$action];
        } else {
            $callback = 'renderError';
        }
        $this->view->render($callback);
        // TODO: Uncomment when finish
        //$this->view->render('renderModeSelection');
    }
}
?>