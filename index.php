<?php
require_once 'define.php';
spl_autoload_register( function( $className ) {
    include LIBRARY_PATH . "{$className}.php";
} );
Session::init();
$bootstrap = new Bootstrap();
$bootstrap->init();