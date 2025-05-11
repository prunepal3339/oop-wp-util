<?php
namespace WPOOPUtil\Admin\Core\Config\Interfaces;

interface OWU_Config_Aware_Interface {
    public function get_config(): OWU_Config_Interface;
    public function set_config( OWU_Config_Interface $config ): void;
}