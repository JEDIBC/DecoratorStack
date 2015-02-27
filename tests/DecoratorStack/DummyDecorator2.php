<?php
namespace Tests\DecoratorStack;

/**
 * Class DummyDecorator2
 *
 * @package Tests\DecoratorStack
 */
class DummyDecorator2 implements DummyInterface
{

    /**
     * @var DummyInterface
     */
    private $object;

    /**
     * @var string
     */
    private $string;

    /**
     * @param DummyInterface $object
     * @param string         $string
     */
    public function __construct(DummyInterface $object, $string)
    {
        $this->object = $object;
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function process()
    {
        return sprintf('%s %s %s', $this->string, $this->object->process(), $this->string);
    }

}
