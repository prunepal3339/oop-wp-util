<?php
namespace WPOOPUtil\CPT\Repository;
use WP_Query;
use WP_Post;
// use WP_Error;
class PostRepository
{
    private WP_Query $query;
    public function __construct(WP_Query $query)
    {
        $this->query = $query;
    }
    public static function init()
    {
        $query = new WP_Query();
        return new self($query);
    }
    public function find_by_id($id)
    {
        return $this->find_one(["p" => $id]);
    }

    public function find_by(string $by, mixed $value, int $limit = 10)
    {
        return $this->find([
            $by => $value,
            "posts_per_page" => $limit,
        ]);
    }

    private function find(array $query)
    {
        $query = array_merge(
            [
                "no_found_rows" => true,
                "update_post_meta_cache" => false,
                "update_post_term_cache" => false,
            ],
            $query
        );
        return $this->query->query($query);
    }

    public function find_one(array $query)
    {
        //get a single post,
        $query = array_merge($query, ["posts_per_page" => 1]);
        return $this->find($query);
    }

    public function remove(WP_Post $post, $force = false)
    {
        wp_delete_post($post->ID, $force);
    }

    public function save(array $post)
    {
        if (!empty($post["ID"])) {
            return wp_update_post($post, true);
        }
        return wp_insert_post($post, true);
    }
}
