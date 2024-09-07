<?php
namespace App\Entities;
class Receita extends BaseEntity {
    protected $attributes = [
        'id' => null,
        'utilizacao' => null,
        'receita_pdf' => null,
        'produtos' => null
    ];

    protected $casts = [
        'id' => 'int',
        'utilizacao' => 'string',
        'receita_pdf' => 'string',
        'produtos' => 'arrayObj[App\Entities\Produto]'
    ];

    protected $castHandlers = [
        'arrayObj' => \App\Entities\Cast\CastArrayObjetos::class
    ];

    protected $datamap = [
        'receitaPdf' => 'receita_pdf'
    ];

    public function __toString(){
        return $this->attributes['id'] ?? 0;
    }
}
?>