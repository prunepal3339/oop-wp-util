# Examples

This directory contains example implementations of the various utilities provided by this package.

## Directory Structure

```
examples/
├── Hooks/           # Examples of using the Hooks system
│   └── ExampleHooks.php
└── README.md        # This file
```

## Usage Examples

### Hooks System

The `ExampleHooks` class demonstrates how to use the Hooks system to register WordPress actions and filters:

```php
use OopWpUtil\Examples\Hooks\ExampleHooks;

// Initialize the hooks
ExampleHooks::init();
```

This will register the following hooks:
- An action hook for `init` with priority 20
- A filter hook for `the_content` with priority 10
- An action hook for `save_post` with priority 10
- A filter hook for `the_title` with priority 10
- A custom action hook with explicit callback

#### Convention-Based Callbacks

The Hooks system supports convention-based callback naming. When you don't specify a callback in the hook configuration, the system will look for a method following this convention:

```
{tag}_{type}_cb
```

For example:
- For `init` action: `init_action_cb`
- For `the_content` filter: `the_content_filter_cb`
- For `save_post` action: `save_post_action_cb`

The system will:
1. First try to find a method matching the exact convention
2. If not found, use reflection to find a method containing the hook tag and type
3. Throw an exception if no suitable method is found

#### Explicit Callbacks

You can still specify explicit callbacks when needed:

```php
array(
    'type'     => 'action',
    'tag'      => 'custom_action',
    'callback' => 'handle_custom_action',
    'priority' => 10,
    'args'     => 1
)
```

## Creating Your Own Implementations

When creating your own implementations:

1. Create a new class extending the appropriate abstract class
2. Implement the required abstract methods
3. Initialize your implementation where needed

For example, to create your own hooks implementation:

```php
use OopWpUtil\Core\Hooks\Abstract\AbstractHooks;

class MyHooks extends AbstractHooks {
    public static function get_hooks() {
        return array(
            // Using convention-based callback
            array(
                'type'     => 'action',
                'tag'      => 'my_action',
                'priority' => 10,
                'args'     => 1
            ),
            // Using explicit callback
            array(
                'type'     => 'filter',
                'tag'      => 'my_filter',
                'callback' => 'custom_filter_handler',
                'priority' => 10,
                'args'     => 2
            ),
        );
    }

    // Convention-based callback
    public static function my_action_action_cb( $arg ) {
        // Your callback implementation
    }

    // Explicit callback
    public static function custom_filter_handler( $value, $arg2 ) {
        // Your filter implementation
        return $value;
    }
}
```