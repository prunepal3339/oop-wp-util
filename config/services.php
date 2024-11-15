return [
    'database' => function() {
        global $wpdb;
        return $wpdb;
    },
    'user' => function() {
        $user = wp_get_current_user();
        return $user;
    }
];
