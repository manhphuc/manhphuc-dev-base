<?php
require_once 'define.php';
require_once 'define-notice.php';
// error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

date_default_timezone_set(DEFAULT_TIMEZONE);
spl_autoload_register( function ( $className ) {
    $fileName = LIBRARY_PATH . "{$className}.php";
    if ( file_exists( $fileName ) ) require_once( $fileName );
});

Session::init();
$bootstrap = new Bootstrap();
$bootstrap->init();
