<?php

namespace App\Core;

use App\Core\IteratorInterface;

class Iterator implements IteratorInterface{
    private $list;
    private int $position = 0;
    private int $length;
    private array $keys;

    public function __construct($list){
        $this->list = $list;
        $this->position = 0;
        $this->length = count($this->list);
        if(is_array($list) && $list !== [])
            $this->keys = array_keys($list);
    }

    public function first(){
        $this->position = 0;
    }

    public function next(){
        $this->position++;
    }

    public function isDone(): bool{
        return $this->position >= $this->length;
    }

    public function current(){
        $this->fixPosition();
        return $this->list[$this->keys[$this->position] ?? $this->position];
    }

    public function length(): int{
        return $this->length;
    }

    public function key(){
        $this->fixPosition();
        return $this->keys[$this->position] ?? $this->position;
    }

    public function keys(): ?array{
        return $this->keys;
    }

    private function fixPosition(){
        $this->position = $this->position >= $this->length ? $this->length - 1 : ($this->position < 0 ? 0 : $this->position);
    }
}