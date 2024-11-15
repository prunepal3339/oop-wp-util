<?php
namespace WPOOPUtil\DependencyInjection;
use Exception;
use ReflectionClass;
class Container
{
    private $services = [];
    private $instances = [];

    public function set(string $name, $service)
    {
        $this->services[$name] = $service;
    }
    public function get(string $name)
    {
        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }

        if (!isset($this->services[$name])) {
            throw new Exception("Service ${name} not found.");
        }

        $service = $this->services[$name];
        if (is_callable($service)) {
            $instance = $service($this);
        } elseif (is_string($service) && class_exists($service)) {
            $instance = $this->resolve($service);
        } else {
            throw new \Exception("Service {$name} could not be resolved");
        }
        $this->instances[$name] = $instance;

        return $instance;
    }

    protected function resolve(string $class)
    {
        $reflectionClass = new ReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor)) {
            return new $class();
        }

        $parameters = $constructor->getParameters();

        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependencyClass = $parameter->getClass();

            if ($dependencyClass) {
                $dependencies[] = $this->get($dependencyClass->name);
            } else {
                // adds argument based resolution
                throw new Exception(
                    "Unable to resolve parameter '{$parameter}'"
                );
            }
        }
        return $reflectionClass->newInstanceArgs($dependencies);
    }
}
