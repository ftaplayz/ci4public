<?php
namespace App\Validation;
class VarTypeRules{
    public function is_bool($value){
        return $value==true||$value==false;
    }
}
?>