<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /** @test */
    function it_wraps_values_in_collections()
    {
        $items = ["one", "two", "three"];
        $collection = collect($items);
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(3, $collection);
    }
}
