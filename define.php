<?php
// ====================== PATHS ===========================
defined( 'DS' ) || define( 'DS', '/' );
defined( 'ROOT_PATH' ) || define( 'ROOT_PATH', dirname( __FILE__) );
defined( 'LIBRARY_PATH' ) || define( 'LIBRARY_PATH', ROOT_PATH . DS . 'libs' . DS );
defined( 'LIBRARY_EXT_PATH' ) || define( 'LIBRARY_EXT_PATH', LIBRARY_PATH . DS . 'extends' . DS );
defined( 'PUBLIC_PATH' ) || define( 'PUBLIC_PATH', ROOT_PATH . DS . 'public' . DS );
defined( 'UPLOAD_PATH' ) || define( 'UPLOAD_PATH', PUBLIC_PATH . DS . 'files' . DS );
defined( 'SCRIPT_PATH' ) || define( 'SCRIPT_PATH', PUBLIC_PATH . DS . 'scripts' . DS );
defined( 'APPLICATION_PATH' ) || define( 'APPLICATION_PATH', ROOT_PATH . DS . 'application' . DS );
defined( 'MODULE_PATH' ) || define( 'MODULE_PATH', APPLICATION_PATH . 'module' . DS );
defined( 'BLOCK_PATH' ) || define( 'BLOCK_PATH', APPLICATION_PATH . 'blocks' . DS );
defined( 'TEMPLATE_PATH' ) || define( 'TEMPLATE_PATH', PUBLIC_PATH . 'template' . DS );
defined( 'ROOT_URL' ) || define( 'ROOT_URL', DS . 'master' . DS );
defined( 'APPLICATION_URL' ) || define( 'APPLICATION_URL', ROOT_URL . 'application' . DS );
defined( 'PUBLIC_URL' ) || define( 'PUBLIC_URL', ROOT_URL . 'public' . DS );
defined( 'UPLOAD_URL' ) || define( 'UPLOAD_URL', PUBLIC_URL . 'files' . DS );
defined( 'TEMPLATE_URL' ) || define( 'TEMPLATE_URL', PUBLIC_URL . 'template' . DS );

defined( 'DEFAULT_MODULE' ) || define( 'DEFAULT_MODULE', 'default' );
defined( 'DEFAULT_CONTROLLER' ) || define( 'DEFAULT_CONTROLLER', 'index' );
defined( 'DEFAULT_ACTION' ) || define( 'DEFAULT_ACTION', 'index' );

// ====================== DATABASE ===========================
defined( 'DB_HOST' ) || define( 'DB_HOST', 'localhost' );
defined( 'DB_USER' ) || define( 'DB_USER', 'yivic' );
defined( 'DB_PASS' ) || define( 'DB_PASS', 'passWord' );
defined( 'DB_NAME' ) || define( 'DB_NAME', 'manhphuc_base_dev_db' );
defined( 'DB_TABLE' ) || define( 'DB_TABLE', 'group' );

// ====================== DATABASE TABLE===========================
defined( 'TBL_GROUP' ) || define( 'TBL_GROUP', 'group' );
defined( 'TBL_USER' ) || define( 'TBL_USER', 'user' );
defined( 'TBL_CATEGORY' ) || define( 'TBL_CATEGORY', 'category' );
defined( 'TBL_BOOK' ) || define( 'TBL_BOOK', 'book' );
defined( 'TBL_PRIVILEGE' ) || define( 'TBL_PRIVILEGE', 'privilege' );
defined( 'TBL_CART' ) || define( 'TBL_CART', 'cart' );

// ====================== CONFIG ===========================
defined( 'TIME_LOGIN' ) || define( 'TIME_LOGIN', 3600 );

