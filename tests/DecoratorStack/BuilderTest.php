<?php
namespace Tests\DecoratorStack;

use DecoratorStack\Builder;

/**
 * Class BuilderTest
 *
 * @package Tests\DecoratorStack
 */
class BuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Object must implement or extend \Tests\DecoratorStack\DummyInterface
     */
    public function testWrongObjectInterfaceShouldThrowException()
    {
        (new Builder('\Tests\DecoratorStack\DummyInterface'))->resolve(new \stdClass());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Decorator must implement or extend \Tests\DecoratorStack\DummyInterface
     */
    public function testWrongDecoratorInterfaceShouldThrowException()
    {
        (new Builder('\Tests\DecoratorStack\DummyInterface'))->push('\Tests\DecoratorStack\FooBarObject')->resolve(new DummyObject());
    }

    /**
     * @test
     */
    public function testDecoration()
    {
        /* @var $decoratedObject DummyInterface */
        $decoratedObject = (new Builder('\Tests\DecoratorStack\DummyInterface'))->push('\Tests\DecoratorStack\DummyDecorator')->resolve(new DummyObject());

        $this->assertEquals('>>> Dummy <<<', $decoratedObject->process());
    }
}