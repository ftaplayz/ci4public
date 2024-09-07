<?php

namespace App\Core;
interface IteratorInterface{
    /**
     * Sets the iterator position to 0
     */
    public function first();

    /**
     * Sets the iterator position to the next one
     */
    public function next();

    /**
     * Checks if the iterator is at last position
     * @return bool True if done
     */
    public function isDone(): bool;

    /**
     * Returns the value at the position the iterator is at
     * @return mixed Value of current position
     */
    public function current();

    /**
     * Returns the data length
     * @return int Data length
     */
    public function length(): int;


    /**
     * Returns the key or index at the position the iterator is at
     * @return mixed Key or index
     */
    public function key();

    /**
     * Checks if the current data is a key pair array and returns the keys
     * @return array|null Keys as an array
     */
    public function keys(): ?array;
}