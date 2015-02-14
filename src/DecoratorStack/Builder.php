<?php
namespace DecoratorStack;

/**
 * Class Builder
 *
 * @package DecoratorStack
 */
class Builder
{

    /**
     * @var \SplStack
     */
    private $stack;

    /**
     * @var string
     */
    private $className;

    /**
     * @param string $className
     */
    public function __construct($className)
    {
        $this->stack     = new \SplStack();
        $this->className = $className;
    }

    /**
     * @param string $className
     * @param array  $args
     *
     * @return $this
     */
    public function push($className, array $args = [])
    {
        $this->stack->push([$className, $args]);

        return $this;
    }

    /**
     * @param mixed $object
     *
     * @return mixed object
     */
    public function resolve($object)
    {
        if (!is_a($object, $this->className)) {
            throw new \InvalidArgumentException(sprintf('Object must implement or extend %s', $this->className));
        }

        while ($this->stack->count() > 0) {
            list($className, $args) = $this->stack->pop();

            array_unshift($args, $object);

            $reflection = new \ReflectionClass($className);
            $object     = $reflection->newInstanceArgs($args);

            if (!is_a($object, $this->className)) {
                throw new \InvalidArgumentException(sprintf('Decorator must implement or extend %s', $this->className));
            }
        }

        return $object;
    }
}