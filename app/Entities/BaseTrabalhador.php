<?php

namespace App\Entities;

class BaseTrabalhador extends BaseEntity{
    protected $attributes = [
        'id' => null,
        'nome' => null,
        'nif' => null,
        'nib' => null,
        'especialidade' => null,
        'morada' => null,
        'codigo_postal' => null
    ];

    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'nif' => 'int',
        'nib' => 'int',
        'especialidade' => 'string',
        'morada' => 'string',
        'codigo_postal' => 'castEntidade[App\Entities\Morada, codigoPostal]'
    ];

    protected $castHandlers = [
        'castEntidade' => \App\Entities\Cast\CastEntidade::class
    ];

    protected $datamap = [
        'codigoPostal' => 'codigo_postal'
    ];

    public function __toString(){
        return $this->attributes['id'] ?? 0;
    }
}

?>