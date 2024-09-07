<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Produto as ProdutoEntity;

class Produto extends Model{
    protected $table = 'produto';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = ProdutoEntity::class;
    protected $allowedFields = ['nome', 'imagem'];

    public function findById(int $id): ?object{
        return $this->find($id);
    }

    public function create(ProdutoEntity &$obj){
        $obj->id = $this->insert($obj, true);
    }

    public function edit(ProdutoEntity $obj){
        $this->update($obj->id, $obj);
    }
}

?>