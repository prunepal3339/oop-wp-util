<?php

namespace OopWpUtil\Core\Ajax\Abstract;

use OopWpUtil\Core\Ajax\Traits\AjaxResponseTrait;

/**
 * Abstract class for handling AJAX requests in WordPress
 *
 * @package OopWpUtil\Core\Ajax\Abstract
 */
abstract class AbstractAjax {
    use AjaxResponseTrait;

    /**
     * Initialize AJAX handlers
     *
     * @since 1.0.0
     * @return void
     */
    public static function init() {
        $ajax_events = static::get_ajax_events();
        self::add_ajax_events( $ajax_events );
    }

    /**
     * Add AJAX events to WordPress
     *
     * @since 1.0.0
     * @param array<string, bool> $ajax_events Array of event names and their nopriv status.
     * @return void
     */
    private static function add_ajax_events( $ajax_events ) {
        foreach ( $ajax_events as $event => $nopriv ) {
            $callback_method = $event . '_cb';
            
            add_action( 'wp_ajax_' . $event, array( static::class, $callback_method ) );

            if ( $nopriv ) {
                add_action( 'wp_ajax_nopriv_' . $event, array( static::class, $callback_method ) );
            }
        }
    }

    /**
     * Get list of AJAX events and their nopriv status
     * 
     * @since 1.0.0
     * @return array<string, bool> Array of event names and their nopriv status.
     */
    abstract public static function get_ajax_events();
}
