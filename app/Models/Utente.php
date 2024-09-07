<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Utente as UtenteEntity;

class Utente extends Model {
    protected $table = 'utente';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = UtenteEntity::class;
    protected $allowedFields = ['nome', 'numero_utente', 'morada', 'codigo_postal'];
    protected $validationRules = [
        'nome' => 'required|string|max_length[80]',
        'numero_utente' => 'required|integer|exact_length[9]',
        'morada' => 'required|string|max_length[100]',
        'codigo_postal' => 'required'
    ];

    public function findById(int $id): ?object{
        return $this->find($id);
    }

    public function create(UtenteEntity &$utente){
        $utente->id = $this->insert($utente, true);
    }

    public function edit(UtenteEntity $utente){
        $this->update($utente->id, $utente);
    }
}
?>