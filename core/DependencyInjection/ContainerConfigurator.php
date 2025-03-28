<?php
namespace WPOOPUtil\DependencyInjection;
use Exception;
class ContainerConfigurator
{
    private $container;
    private $serviceConfigFiles = [];
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    public function addConfigFile(string $path): void
    {
        $this->serviceConfigFiles[] = $path;
    }

    public function configure(): void
    {

        //Allow plugins to load their service config files
        $this->servicesConfigFiles = apply_filters(
            'owu_pre_container_config_build',
            $this->serviceConfigFiles
        );

        foreach ($serviceConfigFiles as $serviceConfigFile) {
            if (!file_exists($serviceConfigFile)) {
                throw new Exception(
                    "Service '{$serviceConfigFile}' does not exist!"
                );
            }
            $services = require $serviceConfigFile;
            //Add or remove services after config is built
            $services = apply_filters('owu_pre_container_service_build', $services);
            foreach ($services as $name => $definition) {
                $this->container->set($name, $definition);
            }
        }
        //modify container after all services are registered
        do_action('owu_post_container_build', $this->container);
    }
}
