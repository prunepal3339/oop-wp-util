<?php

namespace OopWpUtil\Core\Ajax\Traits;

/**
 * Trait for handling AJAX responses
 *
 * @package OopWpUtil\Core\Ajax\Traits
 */
trait AjaxResponseTrait {
    /**
     * Send a JSON response
     *
     * @since 1.0.0
     * @param mixed $data Response data.
     * @param bool  $success Whether the request was successful.
     * @param string $message Optional message.
     * @param int   $status_code HTTP status code.
     * @return void
     */
    public static function send_response( $data, $success = true, $message = '', $status_code = 200 ) {
        wp_send_json( array(
            'success' => $success,
            'data'    => $data,
            'message' => $message
        ), $status_code );
    }

    /**
     * Send an error response
     *
     * @since 1.0.0
     * @param string $message Error message.
     * @param mixed  $data Optional error data.
     * @param int    $status_code HTTP status code.
     * @return void
     */
    public static function send_error( $message, $data = null, $status_code = 400 ) {
        self::send_response( $data, false, $message, $status_code );
    }
}