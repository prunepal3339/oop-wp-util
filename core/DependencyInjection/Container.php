<?php
namespace WPOOPUtil\DependencyInjection;
use Exception;
use ReflectionClass;
use ReflectionParameter;
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
            $dependencies[] = $this->resolveDependency($parameter);
        }
        return $reflectionClass->newInstanceArgs($dependencies);
    }
    private function resolveDependency(ReflectionParameter $parameter)
    {
        //autowiring support
        $type = $parameter->getType();

        //CHECK IF PARAMETER TYPE IS NOT BUILTIN DATA TYPE
        if ($type && !$type->isBuiltIn()) {
            $dependencyClass = new ReflectionClass($type->getName());
            if ($dependencyClass->isInstantiable()) {
                return $this->get($dependencyClass->getName());
            }
        }

        //Parameter injection
        $paramName = $parameter->getName();
        if (isset($this->parameters[$paramName])) {
            return $this->parameters[$paramName];
        }
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new \Exception(
            "Unable to resolve parameter {$parameter->getName()} for class {$parameter->getDeclaringClass()->getName()}"
        );
    }
}
