<?php

namespace AppKit\UI\Support;

use Attribute;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

class Attributes
{
    /**
     * Where we want to look for the attributes
     *
     * @var string|null
     */
    protected ?string $attributeType;

    /**
     * The class of the attribute that we want to find
     *
     * @var string|null
     */
    protected ?string $attributeClass;

    /**
     * The class that we are looking on for the attribute
     *
     * @var string|null
     */
    protected ?string $targetClass;

    /**
     * The method we are looking on for the attribute
     *
     * @var string|null
     */
    protected ?string $targetMethod;

    /**
     * Static constructor for the finder
     *
     * @param string|null $attributeClass
     * @return Attributes
     */
    public static function find(?string $attributeClass): Attributes
    {
        return new self($attributeClass);
    }

    /**
     * Create an instance of the attribute finder
     *
     * @param string $attributeClass
     */
    public function __construct(string $attributeClass)
    {
        $this->attributeClass = $attributeClass;
    }

    /**
     * Set the target class
     *
     * @param string $class
     * @return self
     */
    public function class(string $class): self
    {
        $this->targetClass = $class;

        return $this;
    }

    /**
     * Set the target method
     *
     * @param string $method
     * @return self
     */
    public function method(string $method): self
    {
        $this->targetMethod = $method;

        return $this;
    }

    /**
     * Set the target attribute type
     *
     * @param int $type
     * @return self
     */
    public function type(int $type): self
    {
        $this->attributeType = $type;

        return $this;
    }

    /**
     * Set the attribute that we are looking for
     *
     * @param string $attribute
     * @return self
     */
    public function attribute(string $attribute): self
    {
        $this->attributeClass = $attribute;

        return $this;
    }

    /**
     * Shorthand for searching for attribute on parameters
     *
     * @return self
     */
    public function parameters(): self
    {
        return $this->type(Attribute::TARGET_PARAMETER);
    }

    /**
     * Shorthand for searching for attribute on properties
     *
     * @return self
     */
    public function property(): self
    {
        return $this->type(Attribute::TARGET_PROPERTY);
    }

    /**
     * Shorthand for searching for attribute on properties
     *
     * @return self
     */
    public function onMethods(): self
    {
        return $this->type(Attribute::TARGET_METHOD);
    }

    /**
     * Shorthand for searching on the constructor
     *
     * @return self
     */
    public function onConstructor(): self
    {
        return $this->onMethod('__construct');
    }

    /**
     * Shorthand for searching on the constructor parameters
     *
     * @return self
     */
    public function onConstructorParameters(): self
    {
        return $this->onConstructor()->parameters();
    }

    /**
     * Magic method to handle different ways that this could be called, onMethod, ofMethods etc
     *
     * @param string $name
     * @param mixed $arguments
     * @return void
     */
    public function __call($name, $arguments)
    {
        $nameParts = Str::of($name)->kebab()->split('/-/');

        if (in_array($nameParts[0], ['on', 'of', 'in'])) {
            unset($nameParts[0]);
            $nameParts = $nameParts->values();
        }

        $methodName = Str::of($nameParts[0])->singular()->__toString();

        if (method_exists($this, $methodName)) {
            return $this->{$methodName}(...$arguments);
        } else {
            throw new Exception('Method ' . $name . ' is not valid');
        }
    }

    /**
     * Run the attribute finder
     *
     * @return array
     */
    public function get(): Collection
    {
        $return = [];

        // check that we are looking at parameters (it's the only one implemented so far)
        if ($this->attributeType == Attribute::TARGET_PARAMETER) {
            // get the reflection of the method
            $methodReflection = new ReflectionMethod($this->targetClass, $this->targetMethod);

            // loop through the params on the method
            foreach ($methodReflection->getParameters() as $parameter) {
                // and get the attributes on it
                $attributes = $parameter->getAttributes($this->attributeClass);

                // loop through the attributes
                foreach ($attributes as $attribute) {
                    // and set them on the return array
                    $return[$parameter->getName()] = $attribute->newInstance();
                }
            }

            return new Collection($return);
        } elseif ($this->attributeType == Attribute::TARGET_PROPERTY) {
            // get the reflection of the method
            $classReflection = new ReflectionClass($this->targetClass);

            // loop through the params on the method
            foreach ($classReflection->getProperties() as $property) {
                // and get the attributes on it
                $attributes = $property->getAttributes($this->attributeClass);

                // loop through the attributes
                foreach ($attributes as $attribute) {
                    // and set them on the return array
                    $return[$property->getName()] = $attribute->newInstance();
                }
            }

            return new Collection($return);
        } elseif ($this->attributeType == Attribute::TARGET_METHOD) {
            // get the reflection of the method
            $classReflection = new ReflectionClass($this->targetClass);

            // loop through the params on the method
            foreach ($classReflection->getMethods() as $method) {
                // and get the attributes on it
                $attributes = $method->getAttributes($this->attributeClass);

                // loop through the attributes
                foreach ($attributes as $attribute) {
                    // and set them on the return array
                    $return[$method->getName()] = $attribute->newInstance();
                }
            }

            return new Collection($return);
        } else {
            throw new Exception('Attribute type ' . $this->attributeType . ' is not currently supported');
        }
    }
}
