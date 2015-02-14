<?php
namespace Tests\DecoratorStack;

/**
 * Class DummyObject
 *
 * @package Tests\DecoratorStack
 */
class DummyObject implements DummyInterface
{
    /**
     * @return string
     */
    public function process()
    {
        return 'Dummy';
    }
}