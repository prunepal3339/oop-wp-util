<?php
namespace WPOOPUtil\DependencyInjection;

class ServiceConfigPathLoader
{
    /**
     * Retrieves the path to config/services.php files for all active plugins.
     * @return array An array of file paths to services.php configuration files.
     */
    public function getServiceConfigFiles(): array
    {
        $activePlugins = get_option("active_plugins");
        $serviceConfigFiles = [];
        foreach ($activePlugins as $pluginPath) {
            $pluginDir =
                WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . dirname($pluginPath);
            $servicesFilePath = $pluginDir . "/config/services.php";

            if (file_exists($servicesFilePath)) {
                $serviceConfigFiles[] = $servicesFilePath;
            }
        }
        return $serviceConfigFiles;
    }
}
