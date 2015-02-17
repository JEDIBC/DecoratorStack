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
     * @param string $className
     * @param array  $args
     *
     * @return $this
     */
    public function unshift($className, array $args = [])
    {
        $this->stack->unshift([$className, $args]);

        return $this;
    }

    /**
     * @param mixed $object
     *
     * @return mixed object
     */
    public function resolve($object)
    {
        // Check that object implement/extend $this->className
        if (!is_a($object, $this->className)) {
            throw new \InvalidArgumentException(sprintf('Object must implement or extend %s', $this->className));
        }

        // Return $object if no decorator defined
        if ($this->stack->count() == 0) {
            return $object;
        }

        // Configure stack to iterate backward and position iterator to the start
        $this->stack->setIteratorMode(\SplStack::IT_MODE_LIFO | \SplStack::IT_MODE_KEEP);
        $this->stack->rewind();

        // Iterate
        foreach ($this->stack as $decoratorDefinition) {
            list($className, $args) = $decoratorDefinition;

            // Position $object as first argument of the decorator __construct
            array_unshift($args, $object);

            // Instantiate decorator
            $reflection = new \ReflectionClass($className);
            $object     = $reflection->newInstanceArgs($args);

            // Check that decorator implement/extend $this->className
            if (!is_a($object, $this->className)) {
                throw new \InvalidArgumentException(sprintf('Decorator must implement or extend %s', $this->className));
            }
        }

        return $object;
    }
}