<?php
/**
 * View class of the captures
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
 * capturesView class.
 * Renders the visual representation of the captures available
 */
class capturesView extends Common\appView
{

    /**
     * Constructor for the capturesView class.
     * Sets the page title
     *
     * @param CapturesModel $model
     *            Data model of the Captures page
     */
    public function __construct(CapturesModel $model)
    {
        parent::__construct($model);
        $this->title = _('Captures');
    }

    /**
     * Renders the main content of the captures info inside the rest of the page
     *
     * @see \App\Common\Views\appView::renderContent()
     */
    protected function renderContent()
    {
        /* Captures table */
        $this->pLine('<div class="row">');
        $this->pLine('<div class="col-md-8">', 1);
        /* Toolbar of the table */
        $this->pLine('<div id="toolbar">', 1);
        $this->pLine('<label><input type="checkbox" id="simple" checked>' . _('Simple') . '</label>', 1);
        $this->pLine('<label><input type="checkbox" id="pcap" checked>' . _('Pcap') . '</label>');
        $this->pLine('<label><input type="checkbox" id="autoRefresh">' . _('Auto Refresh') . '</label>');
        $this->pLine('</div>', -1);
        $this->pLine('<div class="table-responsive">');
        $this->pLine('<table class="table"', 1);
        $this->pLine('       data-toggle="table"');
        $this->pLine('       data-search="true"');
        $this->pLine('       data-show-refresh="true"');
        $this->pLine('       data-toolbar="#toolbar">');
        $this->pLine('<thead>', 1);
        $this->pLine('<tr>', 1);
        $this->pLine('<th data-field="name" data-sortable="true">' . _('Name') . '</th>', 1);
        $this->pLine('<th data-field="type" data-sortable="true">' . _('Type') . '</th>');
        $this->pLine('<th data-field="size" data-sortable="true">' . _('Size') . '</th>');
        $this->pLine('<th data-field="date" data-sortable="true">' . _('Date') . '</th>');
        $this->pLine('</tr>', -1);
        $this->pLine('</thead>', -1);
        $this->pLine('</table>', -1);
        $this->pLine('</div>', -1);
        $this->pLine('</div>', -1);

        /* Right action menu */
        $this->pLine('<div class="col-md-4">');
        /* Selected capture */
        $this->pLine('<div class="panel panel-info">', 1);
        $this->pLine('<div class="panel-heading">', 1);
        $this->pLine('<h3 class="panel-title" id="captureName">' . _('Select a capture from the table') . '</h3>', 1);
        $this->pLine('</div>', -1);
        $this->pLine('</div>', -1);

        /* Convert panel */
        $this->pLine('<div class="panel panel-default">');
        $this->pLine('<div class="panel-heading">', 1);
        $this->pLine('<h3 class="panel-title">' . _('Convert') . '</h3>', 1);
        $this->pLine('</div>', -1);
        $this->pLine('<div class="panel-body">');
        $this->pLine('<div class="input-group">', 1);
        $this->pLine('<input type="text" class="form-control" placeholder="' . _('Converted name') . '" id="convertedName" name="convertedName">', 1);
        $this->pLine('<span class="input-group-btn">');
        $this->pLine('<button class="btn btn-default" type="button" id="convertOK" name="convertOK">', 1);
        $this->pLine(_('OK'), 1);
        $this->pLine('</button>', -1);
        $this->pLine('</span>', -1);
        $this->pLine('</div>', -1);
        $this->pLine('</div>', -1);
        $this->pLine('</div>', -1);
        /* Rename panel */
        $this->pLine('<div class="panel panel-default">');
        $this->pLine('<div class="panel-heading">', 1);
        $this->pLine('<h3 class="panel-title">' . _('Rename') . '</h3>', 1);
        $this->pLine('</div>', -1);
        $this->pLine('<div class="panel-body">');
        $this->pLine('<div class="input-group">', 1);
        $this->pLine('<input type="text" class="form-control" placeholder="' . _('New name') . '" id="newName">', 1);
        $this->pLine('<span class="input-group-btn">');
        $this->pLine('<button class="btn btn-default" type="button" id="renameOK">', 1);
        $this->pLine(_('OK'), 1);
        $this->pLine('</button>', -1);
        $this->pLine('</span>', -1);
        $this->pLine('</div>', -1);
        $this->pLine('</div>', -1);
        $this->pLine('</div>', -1);
        /* Delete panel */
        $this->pLine('<div class="panel panel-danger">');
        $this->pLine('<div class="panel-heading" data-toggle="collapse" data-target="#deletePanel">', 1);
        $this->pLine('<h3 class="panel-title" style="cursor: pointer;">' . _('Delete') . '</h3>', 1);
        $this->pLine('</div>', -1);
        $this->pLine('<div class="panel-body collapse" id="deletePanel">');
        $this->pLine('<button type="button" class="btn btn-danger pull-right" id="deleteCapture">', 1);
        $this->pLine(_('Delete this capture (permanently)'), 1);
        $this->pLine('</button>', -1);
        $this->pLine('</div>', -1);
        $this->pLine('</div>', -1);

        $this->pLine('</div>', -1);
        $this->pLine('</div>', -1);

        /* Lower panel with info about adding external captures */
        $this->pLine('<div class="row">');
        $this->pLine('<div class="col-md-8">', 1);
        $this->pLine('<div class="panel panel-info">', 1);
        $this->pLine('<div class="panel-body">', 1);
        $this->pLine('TODO: Info sobre como añadir capturas', 1);
        $this->pLine('</div>', -1);
        $this->pLine('</div>', -1);
        $this->pLine('</div>', -1);
        $this->pLine('</div>', -1);
    }

    /**
     * Renders the end of the document + localization strings
     */
    protected function renderClose()
    {
        parent::renderLocalization();
        parent::renderClose();
    }
}
?>