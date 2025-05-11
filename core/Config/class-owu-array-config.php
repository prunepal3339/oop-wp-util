<?php
namespace WPOOPUtil\Core\Config;

use WPOOPUtil\Core\Config\Interfaces\OWU_Config_Interface;

use function apply_filters;
use function array_key_exists;

class OWU_Array_Config implements OWU_Config_Interface {
    protected array $defaults = [];
    protected array $overrides = [];

    public function __construct( array $defaults = [] ) {
        $this->defaults = $defaults;
    }
    public function get( string $key, mixed $context = [] ) {
        $value = $this->overrides[ $key ] ?? $this->defaults[ $key ] ?? null;
        /**
         * owu_config_value_{config_key}
         * Dynamic filter that modifies the configuration value for the key.
         * 
         * @param mixed $value
         * @param $this
         * 
         */
        return apply_filters( "owu_config_value_{$key}", $value, $this );
    }

    public function set( string $key, mixed $value, mixed $context = [] ): void {
        $this->overrides[ $key ] = $value;
    }
    public function has( string $key, mixed $context = [] ) : bool {
        if( array_key_exists('override_only', $context ) && $context[ 'override_only' ] ) {
            return array_key_exists( $key, $this->overrides );
        }
        return array_key_exists( $key, $this->overrides ) || array_key_exists( $key, $this->defaults );
    }
    public function all( mixed $context = [] ) {
        if ( array_key_exists( 'override_only', $context ) && $context[ 'override_only' ] ) {
            return $this->overrides;
        }
        return array_merge( $this->defaults, $this->overrides );
    }
}
