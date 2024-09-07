<?php

namespace App\Entities;

class Contacto extends BaseEntity{
    protected $attributes = [
        'id' => null,
        'registo' => null,
        'ativo' => null,
    ];

    protected $casts = [
        'id' => 'integer',
        'registo' => 'datetime',
        'ativo' => 'boolean'
    ];

    public function setRegisto($date = null): Contacto{
        if(strtotime($date))
            $this->attributes['registo'] = $date;
        return $this;
    }

    public function __toString(){
        return $this->attributes['id'] ?? 0;
    }
}

?>