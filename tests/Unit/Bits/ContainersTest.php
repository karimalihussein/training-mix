<?php

namespace Tests\Unit\Bits;


use App\Classes\Newsletter;
use App\Containers\Container;
use PHPUnit\Framework\TestCase;

class ContainersTest extends TestCase
{
    /** @test */
    function level_one_it_can_bind_keys_values(): void
    {
        $container = new Container();
        $container->bind('foo', 'bar');
        $this->assertEquals('bar', $container->get('foo'));
    }

    /** @test */
    function level_two_it_can_lazily_resolve_functions()
    {
        $container = new Container();
        $container->bind('newsletter', function () {
            return new Newsletter(uniqid());
        });
        $this->assertInstanceOf(Newsletter::class, $container->get('newsletter'));
    }

    public function testBindAndGetInstance()
    {
        $container = new Container();
        $container->bind('foo', function () {
            return new Newsletter();
        });

        $foo1 = $container->get('foo');
        $foo2 = $container->get('foo');

        $this->assertInstanceOf(Newsletter::class, $foo1);
        $this->assertInstanceOf(Newsletter::class, $foo2);
        $this->assertNotSame($foo1, $foo2);
    }

    public function testSingleton()
    {
        $container = new Container();

        $container->singleton('foo', function () {
            return new Newsletter();
        });

        $foo1 = $container->get('foo');
        $foo2 = $container->get('foo');

        $this->assertInstanceOf(Newsletter::class, $foo1);
        $this->assertInstanceOf(Newsletter::class, $foo2);
        $this->assertSame($foo1, $foo2);
    }


    
}
