<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Morada as MoradaEntity;

class Morada extends Model {
    protected $table = 'morada';
    protected $primaryKey = 'codigo_postal';
    protected $useAutoIncrement = false;
    protected $returnType = MoradaEntity::class;
    protected $allowedFields = ['codigo_postal', 'localidade', 'concelho', 'distrito'];
    protected $validationRules = [
        'codigo_postal' => 'required|numeric|exact_length[7]',
        'localidade' => 'required|string|max_length[50]',
        'concelho' => 'required|string|max_length[50]',
        'distrito' => 'required|string|max_length[50]'
    ];

    public function findByCodigoPostal(int $codigoPostal): ?object{
        return $this->find($codigoPostal);
    }

    public function findById(int $id){
        return $this->findByCodigoPostal($id);
    }

    public function create(MoradaEntity &$obj){
        $obj->id = $this->insert($obj, true);
    }

    public function edit(MoradaEntity $obj){
        $this->update($obj->id, $obj);
    }
}
?>