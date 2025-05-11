<?php
namespace WPOOPUtil\Core\Config\Traits;
use WPOOPUtil\Core\Config\Interfaces\OWU_Config_Interface;
use WPOOPUtil\Core\Config\OWU_Array_Config;
trait OWU_Config_Aware_Trait {

    /**
     * @var OWU_Config_Interface|null
     */
    protected $config;

    /**
     * Get the config object.
     *
     * If not set explicitly, returns a default OWU_Array_Config instance.
     *
     * @return OWU_Config_Interface
     */
    public function get_config(): OWU_Config_Interface {
        if (! $this->config instanceof OWU_Config_Interface) {
            $this->config = new OWU_Array_Config();
        }
        return $this->config;
    }

    /**
     * Set the config object.
     *
     * @param OWU_Config_Interface $config
     */
    public function set_config( OWU_Config_Interface $config ): void {
        $this->config = $config;
    }
}