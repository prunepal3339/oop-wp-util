<?php

namespace OopWpUtil\Core\Hooks\Abstract;

/**
 * Abstract class for managing WordPress hooks (actions and filters)
 *
 * @package OopWpUtil\Core\Hooks\Abstract
 */
abstract class AbstractHooks {
    /**
     * Instance of the class
     *
     * @var self
     */
    private static $instance = null;

    /**
     * Get instance of the class
     *
     * @since 1.0.0
     * @return self
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Initialize hooks
     *
     * @since 1.0.0
     * @return void
     */
    public static function init() {
        // Get explicitly defined hooks
        $explicit_hooks = static::get_hooks();
        
        // Discover hooks from method naming conventions
        $discovered_hooks = self::discover_hooks( static::class );
        
        // Merge and register all hooks, giving priority to explicit hooks
        $hooks = self::merge_hooks( $explicit_hooks, $discovered_hooks );
        self::add_hooks( $hooks );
    }

    /**
     * Merge explicit and discovered hooks, handling collisions.
     * If collision occurs, the explicit hook will take precedence.
     *
     * @since 1.0.0
     * @param array $explicit_hooks Explicitly defined hooks.
     * @param array $discovered_hooks Automatically discovered hooks.
     * @return array Merged hooks array.
     */
    private static function merge_hooks( $explicit_hooks, $discovered_hooks ) {
        // Create array of explicit hook keys
        $explicit_keys = array_column( $explicit_hooks, null, function( $hook ) {
            return $hook['type'] . ':' . $hook['tag'];
        } );

        // Filter out discovered hooks that conflict with explicit ones
        $unique_discovered = array_filter( $discovered_hooks, function( $hook ) use ( $explicit_keys ) {
            return ! isset( $explicit_keys[$hook['type'] . ':' . $hook['tag']] );
        } );

        // Merge arrays, explicit hooks take precedence
        return array_merge( $explicit_hooks, $unique_discovered );
    }

    /**
     * Discover hooks from method naming conventions
     *
     * @since 1.0.0
     * @param string $class Class name.
     * @return array Array of discovered hooks.
     */
    private static function discover_hooks( $class ) {
        $reflection = new \ReflectionClass( $class );
        $methods = $reflection->getMethods( \ReflectionMethod::IS_PUBLIC );
        $discovered_hooks = array();

        foreach ( $methods as $method ) {
            $method_name = $method->getName();
            
            // Skip if method doesn't end with _cb
            if ( substr( $method_name, -3 ) !== '_cb' ) {
                continue;
            }

            // Extract hook type and tag from method name
            if ( preg_match( '/^(.+)_(action|filter)_cb$/', $method_name, $matches ) ) {
                $tag = str_replace( '_', '-', $matches[1] );
                $type = $matches[2];
                
                // Get method parameters to determine number of arguments
                $params = $method->getParameters();
                $args = count( $params );

                // Determine if method is static
                $is_static = $method->isStatic();

                $discovered_hooks[] = array(
                    'type'     => $type,
                    'tag'      => $tag,
                    'callback' => $method_name,
                    'priority' => 10,
                    'args'     => $args,
                    'source'   => 'discovered',
                    'is_static' => $is_static
                );
            }
        }

        return $discovered_hooks;
    }

    /**
     * Add hooks to WordPress
     *
     * @since 1.0.0
     * @param array $hooks Array of hooks to register.
     * @return void
     */
    private static function add_hooks( $hooks ) {
        foreach ( $hooks as $hook ) {
            $type = $hook['type']; // 'action' or 'filter'
            $tag = $hook['tag'];
            $callback = $hook['callback'];
            $priority = $hook['priority'] ?? 10;
            $args = $hook['args'] ?? 1;
            $is_static = $hook['is_static'] ?? false;

            // Prepare callback array based on whether it's static or instance method
            $callback_array = $is_static 
                ? array( static::class, $callback )
                : array( self::get_instance(), $callback );

            if ( 'action' === $type ) {
                add_action( $tag, $callback_array, $priority, $args );
            } else {
                add_filter( $tag, $callback_array, $priority, $args );
            }
        }
    }

    /**
     * Get list of explicitly defined hooks to register
     *
     * @since 1.0.0
     * @return array Array of hooks with their configurations.
     */
    public static function get_hooks() {
        return array();
    }
}