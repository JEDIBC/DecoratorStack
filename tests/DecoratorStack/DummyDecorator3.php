<?php
namespace Tests\DecoratorStack;

/**
 * Class DummyDecorator3
 *
 * @package Tests\DecoratorStack
 */
class DummyDecorator3 implements DummyInterface
{

    /**
     * @var DummyInterface
     */
    private $object;

    /**
     * @param DummyInterface $object
     */
    public function __construct(DummyInterface $object)
    {
        $this->object = $object;
    }

    /**
     * @return string
     */
    public function process()
    {
        return sprintf('[[[ %s ]]]', $this->object->process());
    }

}