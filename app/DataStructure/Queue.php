<?php

declare(strict_types=1);

namespace App\DataStructure;

class Queue
{
    private array $queue = [];

    public function enqueue($item): void
    {
        $this->queue[] = $item;
    }

    public function dequeue()
    {
        return array_shift($this->queue);
    }

    public function isEmpty()
    {
        return empty($this->queue);
    }

    public function peek()
    {
        return current($this->queue);
    }

    public function count()
    {
        return count($this->queue);
    }

    public function clear()
    {
        $this->queue = [];
    }

    public function print()
    {
        echo implode(', ', $this->queue);
    }
}
