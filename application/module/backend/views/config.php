<?php
/**
 * Created by PhpStorm.
 * User: manhphucofficial
 * Date: 05/04/2022
 * Time: 9:59 AM
 */
use Yivic\ManhPhucDevBase\Application\Module\Backend\Views\BEViewConfigs\BEViewConfigs;
require_once MODULE_PATH . 'backend/views/BEViewConfigs.php';
$config = [
    'module_name'       => $this->arrParam['module'],
    'controller_mame'   => $this->arrParam['controller'],
    'add_new_link'      => URL::createLink( $this->arrParam['module'], $this->arrParam['controller'], 'form' ),
    'reload_link'       => URL::createLink( $this->arrParam['module'], $this->arrParam['controller'], 'index' ),
    'search_field'      => $this->params['search_field'] ?? '',
    'search_value'      => isset( $this->params['search_value'] ) ? htmlspecialchars( $this->params['search_value'] ) : '',
];
BEViewConfigs::instance( $config );