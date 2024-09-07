<?php

namespace App\Models;

use App\Core\Iterator;
use CodeIgniter\Model;
use \App\Entities\Consulta as ConsultaEntity;

class Consulta extends Model{
    protected $table = 'consulta';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = ConsultaEntity::class;
    protected $allowedFields = ['data', 'estado', 'id_medico', 'id_utente', 'id_receita'];

    protected $validationRules = [
        'data' => 'required|valid_date',
        'estado' => 'is_bool',
        'id_medico' => 'required',
        'id_utente' => 'required',
        'id_receita' => 'required'
    ];

    public function findById(int $id, bool $enfermeiros = false): ?object{
        if(!$enfermeiros)
            return $this->find($id);
        $list = $this->asArray()->join('consulta_enfermeiro', 'consulta.id = consulta_enfermeiro.id_consulta', 'left')->where('consulta.id', $id)->findAll();
        if(empty($list))
            return null;
        $consulta = new $this->returnType($list[0]);
        $enfIds = [];

        for($it = new Iterator($list);!$it->isDone();$it->next())
            $enfIds[] = $it->current()['id_enfermeiro'];
        $consulta->enfermeiros = $enfIds;
        return $consulta;
    }

    public function create(ConsultaEntity &$consulta){
        $consulta->id = $this->insert($consulta, true);
        if(!empty($consulta->enfermeiros)){
            $this->builder('consulta_enfermeiro')->where('id_consulta', $consulta->id)->delete();
            $list = null;
            for($it = new Iterator($consulta->enfermeiros);!$it->isDone();$it->next())
                $list[] = ['id_consulta' => $consulta->id, 'id_enfermeiro' => $it->current()];
            $this->builder('consulta_enfermeiro')->insertBatch($list);
        }
    }

    public function edit(ConsultaEntity $consulta){
        $this->builder('consulta_enfermeiro')->where('id_consulta', $consulta->id)->delete();
        if(!empty($consulta->enfermeiros)){
            $this->builder('consulta_enfermeiro')->where('id_consulta', $consulta->id)->delete();
            $list = null;
            for($it = new Iterator($consulta->enfermeiros);!$it->isDone();$it->next())
                $list[] = ['id_consulta' => $consulta->id, 'id_enfermeiro' => $it->current()];
            $this->builder('consulta_enfermeiro')->insertBatch($list);
        }
        $this->update($consulta->id, $consulta);
    }


}

?>