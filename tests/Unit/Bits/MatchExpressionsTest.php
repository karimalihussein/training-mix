<?php

namespace Tests\Unit\Bits;

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
