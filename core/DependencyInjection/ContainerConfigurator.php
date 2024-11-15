<?php
namespace WPOOPUtil\DependencyInjection;
use Exception;
class ContainerConfigurator
{
    private $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function configure(array $serviceConfigFiles = []): void
    {
        foreach ($serviceConfigFiles as $serviceConfigFile) {
            if (!file_exists($serviceConfigFile)) {
                throw new Exception(
                    "Service '{$serviceConfigFile}' does not exist!"
                );
            }
            $services = require $serviceConfigFile;
            foreach ($services as $name => $definition) {
                $this->container->set($name, $definition);
            }
        }
    }
}
