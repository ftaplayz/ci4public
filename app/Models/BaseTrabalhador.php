<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Medico as MedicoEntity;

class BaseTrabalhador extends Model {
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nome', 'nif', 'nib','especialidade','morada','codigo_postal'];
    protected $validationRules = [
        'nome' => 'string|required|max_length[80]',
        'nif' => 'required|numeric|exact_length[9]',
        'nib' => 'required|numeric|exact_length[21]',
        'especialidade' => 'required|string|max_length[100]',
        'morada' => 'required|string|max_length[100]',
        'codigo_postal' => 'required'
    ];

    public function create(&$object){
        $object->id = $this->insert($object, true);
    }

    public function edit(&$object){
        $this->update($object->id, $object);
    }
    public function findById(int $id): ?object{
        return $this->find($id);
    }


}
?>