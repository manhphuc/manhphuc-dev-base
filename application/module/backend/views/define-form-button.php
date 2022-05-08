<?php
defined( 'BTN_ACTION' )         || define( 'BTN_ACTION',    isset( $this->arrParam['id'] ) ? "form&id={$this->arrParam['id']}" : "form" );
// Save
defined( 'BTN_LINK_SAVE' )      || define( 'BTN_LINK_SAVE', URL::createLink( $this->arrParam['module'], $this->arrParam['controller'], BTN_ACTION, ['type' => 'save'] ) );
defined( 'BTN_SAVE' )           || define( 'BTN_SAVE',      HTML::createActionButton( "javascript:submitForm('".BTN_LINK_SAVE."')", 'btn-success mr-1', 'Save' ) );

// Save & Close
defined( 'BTN_LINK_SAVE_CLOSE' )|| define( 'BTN_LINK_SAVE_CLOSE', URL::createLink( $this->arrParam['module'], $this->arrParam['controller'], BTN_ACTION, ['type' => 'save-close'] ) );
defined( 'BTN_SAVE_CLOSE' )     || define( 'BTN_SAVE_CLOSE',      HTML::createActionButton("javascript:submitForm('".BTN_LINK_SAVE_CLOSE."')", 'btn-success mr-1', 'Save & Close') );

// Save & New
defined( 'BTN_LINK_SAVE_NEW' )  || define( 'BTN_LINK_SAVE_NEW', URL::createLink( $this->arrParam['module'], $this->arrParam['controller'], BTN_ACTION, ['type' => 'save-new'] ) );
defined( 'BTN_SAVE_NEW' )       || define( 'BTN_SAVE_NEW',      HTML::createActionButton( "javascript:submitForm('".BTN_LINK_SAVE_NEW."')", 'btn-success mr-1', 'Save & New' ) );

// Cancel
defined( 'BTN_LINK_CANCEL' )    || define( 'BTN_LINK_CANCEL',   URL::createLink( $this->arrParam['module'], $this->arrParam['controller'], 'index' ) );
defined( 'BTN_CANCEL' )         || define( 'BTN_CANCEL',        HTML::createActionButton( BTN_LINK_CANCEL, 'btn-danger mr-1', 'Cancel' ) );