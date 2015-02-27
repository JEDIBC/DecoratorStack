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
    public function testObjectReturnedIfNoDecoratorDefined()
    {
        $this->assertEquals(
            'Dummy',
            (new Builder('\Tests\DecoratorStack\DummyInterface'))
                ->resolve(new DummyObject())
                ->process()
        );
    }

    /**
     * @test
     */
    public function testDecorationPushAndUnshift()
    {
        /* @var $decoratedObject DummyInterface */
        $decoratedObject = (new Builder('\Tests\DecoratorStack\DummyInterface'))
            ->push('\Tests\DecoratorStack\DummyDecorator')
            ->push('\Tests\DecoratorStack\DummyDecorator2', ['###'])
            ->push('\Tests\DecoratorStack\DummyDecorator3')
            ->resolve(new DummyObject());

        $this->assertEquals('>>> ### [[[ Dummy ]]] ### <<<', $decoratedObject->process());

        /* @var $decoratedObject DummyInterface */
        $decoratedObject = (new Builder('\Tests\DecoratorStack\DummyInterface'))
            ->push('\Tests\DecoratorStack\DummyDecorator2', ['###'])
            ->push('\Tests\DecoratorStack\DummyDecorator3')
            ->unshift('\Tests\DecoratorStack\DummyDecorator')
            ->resolve(new DummyObject());

        $this->assertEquals('>>> ### [[[ Dummy ]]] ### <<<', $decoratedObject->process());
    }

    /**
     * @test
     */
    public function testMultipleResolveWithSameStack()
    {
        /* @var $decoratedObject DummyInterface */
        $builder = (new Builder('\Tests\DecoratorStack\DummyInterface'))
            ->push('\Tests\DecoratorStack\DummyDecorator')
            ->push('\Tests\DecoratorStack\DummyDecorator2', ['###'])
            ->push('\Tests\DecoratorStack\DummyDecorator3');

        $decoratedObject1 = $builder->resolve(new DummyObject());
        $decoratedObject2 = $builder->resolve(new DummyObject('FooBar'));

        $this->assertEquals('>>> ### [[[ Dummy ]]] ### <<<', $decoratedObject1->process());
        $this->assertEquals('>>> ### [[[ FooBar ]]] ### <<<', $decoratedObject2->process());
    }
}