<?php

namespace App\Entities\Cast;

use CodeIgniter\Entity\Cast\BaseCast;

class CastEntidade extends BaseCast{
    private bool $firstTime;
    /**
     * @param mixed $value Value passed to the setter e.g. $entity = 1; The value passed is 1
     * @param array $params Index 0 for class namespace, index 1 for primary key/value to be set when new entity is created
     * @return array|bool|float|int|mixed|object|string|null It will set the entity property as the value passed
     */
    public static function set($value, array $params = []){
        if(is_object($value) && get_class($value) == $params[0])
            return $value;
        return new $params[0]([$params[1] => $value]);
    }

    public static function get($value, array $params = []){
        if(!is_object($value))
            return new $params[0]([$params[1]=> $value]);
        return $value;
    }
}