<?php

namespace OopWpUtil\Examples\Hooks;

use OopWpUtil\Core\Hooks\Abstract\AbstractHooks;

/**
 * Example implementation of WordPress hooks
 *
 * @package OopWpUtil\Examples\Hooks
 */
class ExampleHooks extends AbstractHooks {
    /**
     * Get list of explicitly defined hooks to register
     *
     * @since 1.0.0
     * @return array Array of hooks with their configurations.
     */
    public static function get_hooks() {
        return array(
            // Only need to define hooks that don't follow the convention
            // or need special configuration
            array(
                'type'     => 'action',
                'tag'      => 'custom_action',
                'callback' => 'handle_custom_action',
                'priority' => 20, // Custom priority
                'args'     => 1,
                'is_static' => true // Explicitly mark as static
            ),
        );
    }

    /**
     * Static callback for init action
     *
     * @since 1.0.0
     * @return void
     */
    public static function init_action_cb() {
        // Do something on init
    }

    /**
     * Instance callback for the_content filter
     *
     * @since 1.0.0
     * @param string $content The post content.
     * @return string Modified content.
     */
    public function the_content_filter_cb( $content ) {
        return $content . '<!-- Modified by ExampleHooks -->';
    }

    /**
     * Static callback for save_post action
     *
     * @since 1.0.0
     * @param int     $post_id Post ID.
     * @param WP_Post $post Post object.
     * @param bool    $update Whether this is an existing post being updated.
     * @return void
     */
    public static function save_post_action_cb( $post_id, $post, $update ) {
        // Do something when a post is saved
    }

    /**
     * Instance callback for the_title filter
     *
     * @since 1.0.0
     * @param string $title The post title.
     * @param int    $id The post ID.
     * @return string Modified title.
     */
    public function the_title_filter_cb( $title, $id ) {
        return $title . ' (ID: ' . $id . ')';
    }

    /**
     * Custom action handler with explicit callback
     *
     * @since 1.0.0
     * @param mixed $data Action data.
     * @return void
     */
    public static function handle_custom_action( $data ) {
        // Handle custom action
    }
}