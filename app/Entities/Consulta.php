<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Consulta extends BaseEntity{
    protected $attributes = [
        'id' => null,
        'data' => null,
        'estado' => null,
        'id_medico' => null,
        'id_utente' => null,
        'id_receita' => null,
        'enfermeiros' => null
    ];

    protected $casts = [
        'id' => 'id',
        'data' => 'datetime',
        'estado' => 'boolean',
        'id_medico' => 'castEntidade[App\Entities\Medico, id]',
        'id_receita' => 'castEntidade[App\Entities\Receita, id]',
        'id_utente' => 'castEntidade[App\Entities\Utente, id]',
        'enfermeiros' => 'arrayObj[App\Entities\Enfermeiro]'
    ];

    protected $datamap = [
        'medico' => 'id_medico',
        'utente' => 'id_utente',
        'receita' => 'id_receita'
    ];

    protected $castHandlers = [
        'castEntidade' => \App\Entities\Cast\CastEntidade::class,
        'arrayObj' => \App\Entities\Cast\CastArrayObjetos::class
    ];

    public function __toString(){
        return $this->attributes['id'];
    }

}

?>