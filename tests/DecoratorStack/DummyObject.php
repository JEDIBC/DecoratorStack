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
     * @var string
     */
    protected $text = '';

    /**
     * @param string $text
     */
    public function __construct($text = 'Dummy')
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function process()
    {
        return $this->text;
    }
}