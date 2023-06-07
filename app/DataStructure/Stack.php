<?php

namespace App\DataStructure;

class Stack
{
    private array $stack;

    public function __construct()
    {
        $this->stack = [];
    }

    public function push($item): void
    {
        $this->stack[] = $item;
    }

    public function pop(): string
    {
        return array_pop($this->stack);
    }

    public function peek(): string
    {
        return end($this->stack);
    }

    public function isEmpty(): bool
    {
        return empty($this->stack);
    }

    public function size(): int
    {
        return count($this->stack);
    }

    public function printStack(): void
    {
        echo implode(', ', $this->stack);
    }
}
