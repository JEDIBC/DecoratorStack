# JEDIBC/DecoratorStack

[![Build Status](https://travis-ci.org/JEDIBC/DecoratorStack.png)](https://travis-ci.org/JEDIBC/DecoratorStack)

A simple tool for stacking decorators.

## Installation

The recommended way to install the library is through [Composer](http://getcomposer.org/). Require the `jedibc/decorator-stack` package into your `composer.json` file:

```json
{
    "require": {
        "jedibc/decorator-stack": "@stable"
    }
}
```

## Usage

Currently, if you want to decorate an object, you'll have to do something like this :

```php
$decoratedObject = new Foo\Bar\Decorator1(
	new Foo\Bar\Decorator2(
    	new Foo\Bar\Decorator3(
        	new ObjectToDecorate()
        ), [$someConstuctorArgument])
);
```

The more decorators you have, the more ugly your code become.

With DecoratorStack, you can simplify it :

```php
$stack = (new DecoratorStack\Builder('Foo\Bar\DummyInterface'))
	->push('Foo\Bar\Decorator1')
	->push('Foo\Bar\Decorator2', [$someConstuctorArgument])
	->push('Foo\Bar\Decorator3');

$decoratedObject = $stack->resolve(new ObjectToDecorate())
```

Each decorator and the object to decorate **must** implement the ```Foo\Bar\DummyInterface``` (or it can be extending an abstract class).

## Inspiration

* [stackphp/builder](https://github.com/stackphp/builder)
* [swarrot/swarrot](https://github.com/swarrot/swarrot)


## License

DecoratorStack is released under the MIT License. See the bundled LICENSE file for details.