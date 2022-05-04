<?php
/**
 * Created by PhpStorm.
 * User: manhphucofficial
 * Date: 05/04/2022
 * Time: 10:10 AM
 */
namespace Yivic\ManhPhucDevBase\Application\Module\Backend\Views\BEViewConfigs;

class BEViewConfigs {
    /**
     * @var null|BEViewConfigs
     */
    static protected $_instance = null;

    /**
     * @var null|ViewsConfigs
     */
    public $module_name     = null;
    public $controller_mame = null;
    public $add_new_link    = null;
    public $reload_link     = null;
    public $search_field    = null;
    public $search_value    = null;

    /**
     * BEViewConfigs constructor.
     * Only invoked for singleton object
     *
     * @param null $config
     */
    private function __construct( $config = null ) {
        foreach ( $config as $config_key => $config_val ) {
            if ( property_exists( $this, $config_key ) ) {
                $this->$config_key = $config_val;
            }
        }
    }

    /**
     * Get singleton instance
     *
     * @param $config null|array config params for the instance
     *
     * @return static|null
     */
    public static function instance( $config = null ) {
        if ( null === static::$_instance ) {
            static::$_instance = new static( $config );
        }

        return static::$_instance;
    }

    /**
     * Get Module Name
     *
     * @return ViewsConfigs|null
     */
    public static function module_name() {
        return static::instance()->module_name;
    }

    /**
     * Get Controller Name
     *
     * @return null|string
     */
    public static function controller_mame() {
        return static::instance()->controller_mame;
    }


    /**
     * Get Add New link
     *
     * @return null|string
     */
    public static function add_new_link() {
        return static::instance()->add_new_link;
    }

    /**
     * Get Reload Link
     *
     * @return null|string
     */
    public static function reload_link() {
        return static::instance()->reload_link;
    }

    /**
     * Get Search Field
     *
     * @return null|string
     */
    public static function search_field() {
        return static::instance()->search_field;
    }

    /**
     * Get Search Value
     *
     * @return null|string
     */
    public static function search_value() {
        return static::instance()->search_value;
    }
}