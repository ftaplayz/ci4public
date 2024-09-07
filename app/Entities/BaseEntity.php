<?php

namespace App\Entities;

use App\Core\Iterator;
use CodeIgniter\Entity\Entity;

abstract class BaseEntity extends Entity{
    abstract function __toString();
    public function listPropertiesWithDataMap(): array{
        $arr = [];
        for($iterator = new Iterator($this->attributes); !$iterator->isDone(); $iterator->next()){
            $key = $iterator->key();
            $f = array_search($key, $this->datamap);
            $key = $f?$f:$key;
            $arr[$key] = $iterator->current();
        }
        return $arr;
    }
}

?>