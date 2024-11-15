<?php
namespace WPOOPUtil\CPT\Entity;
use WP_Post;
use property_exists;
use strtolower, preg_replace;
/**
 * Proxy class for WP_Post with modern API
 */
class Post
{
    protected int $id;
    protected WP_Post|false $post;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->post = WP_Post::get_instance($id);
    }
    public function exists(): bool
    {
        return $this->post ? true : false;
    }
    public function __get($key)
    {
        //convert camelCase key to snake_case key
        $key = \strtolower(\preg_replace("/([a-z])([A-Z])/", "$1_$2", $key));

        if (\property_exists($this->post, $key)) {
            return $this->post->{$key};
        }
    }
}
