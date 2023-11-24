<?php

declare(strict_types=1);

namespace App\Containers;

use Closure;
use Exception;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;

class Container
{
    protected array $bindings = [];

    protected array $singletons = [];

    /**
     * Binds a given abstract to a concrete implementation or closure.
     */
    public function bind(string $abstract, string|Closure $concrete, bool $shared = false): void
    {
        $this->bindings[$abstract] = compact('concrete', 'shared');
    }

    /**
     * Binds a given abstract to a concrete implementation or closure as a singleton.
     */
    public function singleton(string $abstract, string|Closure $concrete): void
    {
        $this->bind($abstract, $concrete, true);
    }

    /**
     * Resolves the given abstract out of the container.
     *
     * @throws Exception
     */
    public function get(string $abstract): mixed
    {
        if (!isset($this->bindings[$abstract])) {
            if (class_exists($abstract)) {
                return $this->resolveClass($abstract);
            }
            throw new Exception("No binding found for {$abstract}");
        }

        $binding = $this->bindings[$abstract];

        if ($binding['shared'] && isset($this->singletons[$abstract])) {
            return $this->singletons[$abstract];
        }

        $concrete = $binding['concrete'];

        if (!$concrete instanceof Closure) {
            return $concrete;
        }

        $object = $concrete($this);

        if ($binding['shared']) {
            $this->singletons[$abstract] = $object;
        }

        return $object;
    }

    /**
     * Resolves the given class out of the container.
     *
     * @throws Exception
     */
    protected function resolveClass(string $class): mixed
    {
        $reflector = new ReflectionClass($class);

        if (!$constructor = $reflector->getConstructor()) {
            return new $class();
        }

        $dependencies = $this->resolveDependencies($constructor->getParameters());

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * Resolves the dependencies for the given array of parameters.
     *
     * @param  ReflectionParameter[]  $parameters
     *
     * @throws Exception
     */
    protected function resolveDependencies(array $parameters): array
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                $dependencies[] = $this->getDependency($parameter);
            }
        }

        return $dependencies;
    }

    /**
     * Resolves the dependency for the given parameter.
     *
     * @throws Exception
     */
    protected function getDependency(ReflectionParameter $parameter): mixed
    {
        $dependency = $parameter->getType();

        if ($dependency instanceof ReflectionNamedType) {
            return $this->get($dependency->getName());
        }

        throw new Exception("Cannot resolve dependency for {$parameter->getName()}");
    }
}
