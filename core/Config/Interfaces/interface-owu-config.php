<?php
namespace WPOOPUtil\Core\Config\Interfaces;
interface OWU_Config_Interface {
    public function get( string $key, mixed $context = [] );
    public function set( string $key, mixed $value, mixed $context = [] );
    public function has( string $key, mixed $context = [] );
    public function all( mixed $context = [] );
}
