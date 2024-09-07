<?php

namespace App\Entities\Cast;

use App\Core\Iterator;
use CodeIgniter\Entity\Cast\BaseCast;

class CastArrayObjetos extends BaseCast{
    /**
     * @param array $value Array containing ids as integer or objects
     * @param array $params Index 0 for the entity path
     * @return array Returns the array that contains a list of $param[0] objects or the ids
     */
    public static function set($value, array $params = []){
        if(!is_array($value))
            return [];
        $add = [];
        for($it = new Iterator($value); !$it->isDone(); $it->next()){
            $val = is_string($it->current())?(int)$it->current():$it->current();
            if(is_int($val)|| (is_object($val) && get_class($val) == $params[0]) )
                $add[] = $val;
        }
        return $add;
    }
}