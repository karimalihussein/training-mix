<?php

namespace Tests\Unit\Bits;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /** @test */
    public function it_wraps_values_in_collections()
    {
        $items = ['one', 'two', 'three'];
        $collection = collect($items);
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(3, $collection);
    }
}
