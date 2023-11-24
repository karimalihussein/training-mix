<?php

declare(strict_types=1);

namespace App\DataStructure;

class SinglyLinkedLists
{
    // Implementation for Singly Linked Lists

    public $head = null;
    public $tail = null;

    public function __construct()
    {
        $this->head = null;
        $this->tail = null;
    }

    public function add($value): void
    {
        $node = new Node($value);

        if ($this->head === null) {
            $this->head = $node;
        } else {
            $this->tail->next = $node;
        }

        $this->tail = $node;
    }

    public function remove($value): void
    {
        $current = $this->head;
        $previous = null;

        while ($current !== null) {
            if ($current->value === $value) {
                if ($previous === null) {
                    $this->head = $current->next;
                } else {
                    $previous->next = $current->next;
                }
                break;
            }
            $previous = $current;
            $current = $current->next;
        }
    }

    public function contains($value): bool
    {
        $current = $this->head;

        while ($current !== null) {
            if ($current->value === $value) {
                return true;
            }
            $current = $current->next;
        }

        return false;
    }

    public function print(): void
    {
        $current = $this->head;

        while ($current !== null) {
            echo $current->value . ' ';
            $current = $current->next;
        }
        echo PHP_EOL;
    }

    public function reverse(): void
    {
        $current = $this->head;
        $previous = null;
        $next = null;

        while ($current !== null) {
            $next = $current->next;
            $current->next = $previous;
            $previous = $current;
            $current = $next;
        }

        $this->head = $previous;
    }


}
