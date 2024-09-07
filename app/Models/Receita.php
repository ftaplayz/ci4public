<?php
namespace App\Models;

use App\Core\Iterator;
use App\Entities\Receita as ReceitaEntity;
use CodeIgniter\Model;

class Receita extends Model {
    protected $table = 'receita';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = ReceitaEntity::class;
    protected $allowedFields = ['utilizacao', 'receita_pdf'];

    public function findById(int $id, bool $produtos = false): ?object{
        if(!$produtos)
            return $this->find($id);
        $list = $this->asArray()->join('receita_produto', 'receita.id = receita_produto.id_receita', 'left')->where('receita.id', $id)->findAll();
        if(empty($list))
            return null;
        $receita = new $this->returnType($list[0]);
        $enfIds = [];
        for($it = new Iterator($list); !$it->isDone(); $it->next())
            $enfIds[] = $it->current()['id_produto'];
        $receita->produtos = $enfIds;
        return $receita;
    }

    public function create(ReceitaEntity &$obj){
        $obj->id = $this->insert($obj, true);
        if(!empty($obj->produtos)){
            $list = null;
            for($it = new Iterator($obj->produtos);!$it->isDone();$it->next())
                $list[] = ['id_receita' => $obj->id, 'id_produto' => $it->current()];
            $this->builder('receita_produto')->insertBatch($list);
        }
    }

    public function edit(ReceitaEntity $obj){
        $this->builder('receita_produto')->where('id_receita', $obj->id)->delete();
        if(!empty($obj->produtos)){
            $list = null;
            for($it = new Iterator($obj->produtos);!$it->isDone();$it->next())
                $list[] = ['id_receita' => $obj->id, 'id_produto' => $it->current()];
            $this->builder('receita_produto')->insertBatch($list);
        }
        $this->update($obj->id, $obj);
    }
}
?>