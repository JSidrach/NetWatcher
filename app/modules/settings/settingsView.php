<?php
/**
 * View class of the settings
 *
 * Inherits from appView class
 *
 * @package App
 */

/**
 * App namespace (user defined behaviour)
 */
namespace App;

/**
 * settingsView class.
 * Renders the visual representation of the settings
 */
class settingsView extends Common\appView
{

    /**
     * Constructor for the settingsView class.
     * Sets the page title
     *
     * @param SettingsModel $model
     *            Data model of the Settings page
     */
    public function __construct(SettingsModel $model)
    {
        parent::__construct($model);
        $this->title = _('Settings');
    }

    /**
     * Renders the main content of the page inside the rest of the page
     *
     * @see \App\Common\Views\appView::renderContent()
     */
    protected function renderContent()
    {
        /* Form for settings */
        $this->pLine('<form class="form-horizontal" role="form" action="settings/save" method="post">', 0);
        
        /* Server settings */
        $this->pLine('<h3>' . _('Server Settings') . '</h3><hr>', 1);
        $this->pLine('<div class="form-group">', 0);
        $this->pLine('<label for="serverIp" class="col-sm-2 control-label">' . _('Server IP') . '</label>', 1);
        $this->pLine('<div class="col-sm-6">', 0);
        $this->pLine('<input type="text" class="form-control" name="serverIp" id="serverIp" value="' . \Core\Config::$REMOTE_SERVER_IP . '">', 1);
        $this->pLine('</div>', - 1);
        $this->pLine('</div>', - 1);
        
        /* App settings */
        $this->pLine('<h3>' . _('App Settings') . '</h3><hr>', 0);
        /* Language */
        $this->pLine('<div class="form-group">', 0);
        $this->pLine('<label for="language" class="col-sm-2 control-label">' . _('Language') . '</label>', 1);
        $this->pLine('<div class="col-sm-6">', 0);
        $this->pLine('<select class="form-control custom" name="language" id="language">', 1);
        foreach (\Core\Config::$LANGUAGES as $text => $lang) {
            if ($text == \Core\Config::$DEFAULT_LANG) {
                $this->pLine('<option value="' . $text . '" selected>' . $text . '</option>', 0);
            } else {
                $this->pLine('<option value="' . $text . '">' . $text . '</option>', 0);
            }
        }
        $this->pLine('</select>', 0);
        $this->pLine('</div>', - 1);
        $this->pLine('</div>', - 1);
        /* Theme */
        $this->pLine('<div class="form-group">', 0);
        $this->pLine('<label for="theme" class="col-sm-2 control-label">' . _('Theme') . '</label>', 1);
        $this->pLine('<div class="col-sm-6">', 0);
        $this->pLine('<select class="form-control custom" name="theme" id="theme">', 1);
        foreach (\Core\Config::$CSS_THEMES as $text => $theme) {
            if ($text == \Core\Config::$DEFAULT_CSS_THEME) {
                $this->pLine('<option value="' . $text . '" selected>' . $text . '</option>', 0);
            } else {
                $this->pLine('<option value="' . $text . '">' . $text . '</option>', 0);
            }
        }
        $this->pLine('</select>', 0);
        $this->pLine('</div>', - 1);
        $this->pLine('</div>', - 1);
        
        /* Save button */
        $this->pLine('<div class="form-group">', 0);
        $this->pLine('<div class="col-sm-offset-2 col-sm-2">', 1);
        $this->pLine('<button type="submit" class="btn btn-default">' . _('Save') . '</button>', 1);
        $this->pLine('</div>', - 1);
        $this->pLine('</div>', - 1);
        $this->pLine('</form>', - 1);
    }
}
?>