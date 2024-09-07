<?php

namespace App\Entities;

class Utente extends BaseEntity{
    protected $attributes = [
        'id' => null,
        'nome' => null,
        'numero_utente' => null,
        'morada' => null,
        'codigo_postal' => null
    ];

    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'numero_utente' => 'integer',
        'morada' => 'string',
        'codigo_postal' => 'castEntidade[App\Entities\Morada, codigoPostal]'
    ];

    protected $datamap = [
        'numeroUtente' => 'numero_utente',
        'codigoPostal' => 'codigo_postal'
    ];

    protected $castHandlers = [
        'castEntidade' => \App\Entities\Cast\CastEntidade::class
    ];


    public function __toString(){
        return $this->attributes['id'] ?? 0;
    }
}

?>