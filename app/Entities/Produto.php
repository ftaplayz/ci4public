<?php
namespace App\Entities;

class Produto extends BaseEntity {
    protected $attributes = [
        'id' => null,
        'nome' => null,
        'imagem' => null
    ];

    protected $casts = [
        'id' => 'int',
        'nome' => 'string',
        'imagem' => 'string'
    ];

    public function __toString(){
        return $this->attributes['id'] ?? 0;
    }
}
?>