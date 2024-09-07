<?php

namespace App\Entities;

class Morada extends BaseEntity{
    protected $attributes = [
        'codigo_postal' => null,
        'localidade' => null,
        'concelho' => null,
        'distrito' => null
    ];

    protected $casts = [
        'codigo_postal' => 'integer',
        'localidade' => 'string',
        'concelho' => 'string',
        'distrito' => 'string'
    ];

    protected $datamap = [
        'codigoPostal' => 'codigo_postal'
    ];

    public function __toString(){
        return $this->codigoPostal ?? 0;
    }
}

?>