<?php

namespace App\Models;

use CodeIgniter\Model;
use \App\Entities\Contacto as ContactoEntity;

class Contacto extends Model{
    protected $table = 'contacto';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = ContactoEntity::class;
    protected $allowedFields = ['ativo'];
    protected $validationRules = [
        'ativo' => 'is_bool'
    ];

    public function findById(int $id){
        return $this->find($id);
    }

    public function create(ContactoEntity &$contacto){
        $this->newContacto($contacto);
    }

    public function edit(ContactoEntity $contacto): bool{
        return $this->updateContacto($contacto);
    }

    public function newContacto(ContactoEntity &$contacto){
        $contacto->id = $this->insert($contacto, true);
    }

    public function updateContacto(ContactoEntity $contacto): bool{
        return $this->update($contacto->id, $contacto);
    }

    public function findWithinDateRange(string $date1, string $date2): ?array{
        if(!($dateC1 = strtotime($date1)) || !($dateC2 = strtotime($date2)) || $dateC1 > $dateC2)
            return null;
        return $this->where('registo >=', $date1)->where('registo <=', $date2)->findAll();
    }
}