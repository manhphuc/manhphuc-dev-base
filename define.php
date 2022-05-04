<?php
// ====================== PATHS ===========================
defined( 'DS' ) || define( 'DS', '/' );
defined( 'ROOT_PATH' ) || define( 'ROOT_PATH', dirname(  __FILE__ ) );
defined( 'LIBRARY_PATH' ) || define( 'LIBRARY_PATH', ROOT_PATH . DS . 'libs' . DS );
defined( 'LIBRARY_EXT_PATH' ) || define( 'LIBRARY_EXT_PATH', LIBRARY_PATH . DS . 'extends' . DS );
defined( 'PUBLIC_PATH' ) || define( 'PUBLIC_PATH', ROOT_PATH . DS . 'public' . DS );
defined( 'UPLOAD_PATH' ) || define( 'UPLOAD_PATH', PUBLIC_PATH . DS . 'files' . DS );
defined( 'SCRIPT_PATH' ) || define( 'SCRIPT_PATH', PUBLIC_PATH . DS . 'scripts' . DS );
defined( 'APPLICATION_PATH' ) || define( 'APPLICATION_PATH', ROOT_PATH . DS . 'application' . DS );
defined( 'MODULE_PATH' ) || define( 'MODULE_PATH', APPLICATION_PATH . 'module' . DS );
defined( 'BLOCK_PATH' ) || define( 'BLOCK_PATH', APPLICATION_PATH . 'blocks' . DS );
defined( 'TEMPLATE_PATH' ) || define( 'TEMPLATE_PATH', PUBLIC_PATH . 'template' . DS );
defined( 'ROOT_URL' ) || define( 'ROOT_URL', DS . 'manhphuc-dev-base' . DS );
defined( 'APPLICATION_URL' ) || define( 'APPLICATION_URL', ROOT_URL . 'application' . DS );
defined( 'PUBLIC_URL' ) || define( 'PUBLIC_URL', ROOT_URL . 'public' . DS );
defined( 'UPLOAD_URL' ) || define( 'UPLOAD_URL', PUBLIC_URL . 'files' . DS );
defined( 'TEMPLATE_URL' ) || define( 'TEMPLATE_URL', PUBLIC_URL . 'template' . DS );

defined( 'DEFAULT_MODULE' ) || define( 'DEFAULT_MODULE', 'default' );
defined( 'DEFAULT_CONTROLLER' ) || define( 'DEFAULT_CONTROLLER', 'index' );
defined( 'DEFAULT_ACTION' ) || define( 'DEFAULT_ACTION', 'index' );

// ====================== DATABASE ===========================
defined( 'DATABASE_TYPE' ) || define( 'DATABASE_TYPE', 'mysql' ); //sqlite
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
defined( 'DATETIME_FORMAT' ) || define('DATETIME_FORMAT',       'd/m/Y H:i:s');
defined( 'DB_DATETIME_FORMAT' ) || define('DB_DATETIME_FORMAT',    'Y-m-d H:i:s');
defined( 'DEFAULT_TIMEZONE' ) || define('DEFAULT_TIMEZONE',      'Asia/Ho_Chi_Minh');
defined( 'TIME_LOGIN' ) || define( 'TIME_LOGIN', 3600 );
defined( 'URL_FRIENDLY' ) || define( 'URL_FRIENDLY', true );

defined( 'TEMPLATE_STATUS' ) || define('TEMPLATE_STATUS', [
    'all'       => ['name' => 'All',        'class' => 'bg-info'],
    'active'    => ['name' => 'Active',     'class' => 'bg-success'],
    'inactive'  => ['name' => 'Inactive',   'class' => 'bg-warning']
]);
defined( 'TEMPLATE_STATUS_CART' ) || define('TEMPLATE_STATUS_CART', [
    'all'       => ['name' => 'Tất cả',        'class' => 'bg-info'],
    'active'    => ['name' => 'Đã xử lý',     'class' => 'bg-success'],
    'inactive'  => ['name' => 'Chưa xử lý',   'class' => 'bg-warning']
]);

defined( 'TEMPLATE_SEARCH' ) || define( 'TEMPLATE_SEARCH', [
    'all'           => ['name' => 'Search by All'],
    'id'            => ['name' => 'Search by ID'],
    'name'          => ['name' => 'Search by Name'],
    'username'      => ['name' => 'Search by Username'],
    'fullname'      => ['name' => 'Search by Fullname'],
    'email'         => ['name' => 'Search by Email'],
    'description'   => ['name' => 'Search by Description'],
    'content'       => ['name' => 'Search by Content'],
    'link'          => ['name' => 'Search by Link'],
] );

defined('CONFIG_SEARCH') || define( 'CONFIG_SEARCH', [
    'default'   => ['all', 'id'],
    'group'     => ['all', 'id', 'name'],
    'user'      => ['all', 'id', 'username', 'email', 'fullname'],
    'category'  => ['all', 'id', 'name'],
    'book'      => ['all', 'id', 'name'],
    'slider'    => ['all', 'id', 'name', 'description', 'link'],
    'blog'      => ['all', 'id', 'name', 'description', 'content'],
    'cart'      => ['all', 'id', 'username'],
] );


