<?php
$action             = isset($this->arrParam['id']) ? "form&id={$this->arrParam['id']}" : "form";
// Save
$linkSave           = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], $action, ['type' => 'save']);
$btnSave            = HTML::createActionButton("javascript:submitForm('$linkSave')", 'btn-success mr-1', 'Save');

// Save & Close
$linkSaveClose      = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], $action, ['type' => 'save-close']);
$btnSaveClose       = HTML::createActionButton("javascript:submitForm('$linkSaveClose')", 'btn-success mr-1', 'Save & Close');

// Save & New
$linkSaveNew        = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], $action, ['type' => 'save-new']);
$btnSaveNew         = HTML::createActionButton("javascript:submitForm('$linkSaveNew')", 'btn-success mr-1', 'Save & New');

// Cancel
$linkCancel         = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], 'index');
$btnCancel          = HTML::createActionButton($linkCancel, 'btn-danger mr-1', 'Cancel');
