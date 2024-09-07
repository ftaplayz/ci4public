<?php

namespace App\Controllers;

use App\Core\Iterator;
use CodeIgniter\CodeIgniter;

class Consulta extends BaseController{
    public function index(int $id){
        if(!$this->isLoggedIn()){
            session()->setFlashdata('err', 'Não tem sessão iniciada');
            return redirect()->back();
        }
        $modelConsulta = model(\App\Models\Consulta::class);
        $consulta = $modelConsulta->findById($id, true);

        if($consulta){
            $modelEnfermeiro = model(\App\Models\Enfermeiro::class);
            if(!empty($consulta->enfermeiros)){
                $enf = [];
                for($it = new Iterator($consulta->enfermeiros);!$it->isDone();$it->next())
                    $enf[] = $modelEnfermeiro->findById($it->current()) ?? 0;
                $consulta->enfermeiros = $enf;
            }
        }
        $consulta->receita = model(\App\Models\Receita::class)->findById($consulta->receita->id, true);
        if(!$consulta->receita->id){
            session()->setFlashdata('err', "Consulta id $id não tem receita");
            return redirect()->back();
        }
        $consulta->medico = model(\App\Models\Medico::class)->findById($consulta->medico->id);
        $consulta->utente = model(\App\Models\Utente::class)->findById($consulta->utente->id);

        $modelProduto = model(\App\Models\Produto::class);
        $ents = [];
        for($it = new Iterator($consulta->receita->produtos); !$it->isDone(); $it->next())
            $ents[] = $modelProduto->findById($it->current());
        $consulta->receita->produtos = $ents;

        $data = [
            'consulta' => $consulta
        ];
        return $this->loadDefaultView(['page' => 'consulta', 'data' => $data], ['title' => 'Consulta ' . $consulta->id]);
    }
}

?>