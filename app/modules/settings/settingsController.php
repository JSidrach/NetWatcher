<?php
/**
 * Controller class of the settings
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
 * settingsController class.
 * Saves the new settings
 */
class settingsController extends Common\appController
{

    /**
     * Default inherited constructor for the settingsController class
     *
     * @param SettingsModel $model
     *            Data model of the Settings page
     * @param SettingsView $view
     *            View representation of the Settings page
     */
    public function __construct(SettingsModel $model, SettingsView $view)
    {
        parent::__construct($model, $view);
    }

    /**
     * Saves the new settings and calls the render
     *
     * @param array $args
     *            Array containing the request
     */
    public function save(array $args)
    {
        /* Save the settings */
        $settings['lang'] = $_REQUEST['language'];
        $settings['theme'] = $_REQUEST['theme'];
        $settings['serverIp'] = $_REQUEST['serverIp'];
        $ctrl = $this->model->saveSettings($settings);
        
        /* Loads the new settings */
        \Core\Config::dynamicLoad();
        
        /* Renders the page */
        $this->view->title = _('Settings');
        $this->view->render();
        
        /* Renders the notification */
        if ($ctrl === TRUE) {
            $this->view->renderNotification(_('Settings saved successfully'), 'success');
        } else {
            $this->view->renderNotification(_('Error saving settings'), 'danger');
            \Core\Logger::logWarning('Failed to save settings');
        }
    }
}
?>