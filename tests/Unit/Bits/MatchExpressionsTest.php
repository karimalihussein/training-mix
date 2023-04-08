<?php

namespace Tests\Unit\Bits;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\TestCase;

class MatchExpressionsTest extends TestCase
{
    public function test_match_expressions_with_value()
    {
        $value = 10;
        match ($value) {
            10 => $this->assertTrue(true),
            default => $this->assertTrue(false),
        };

    }
   
}
