<?php

namespace App\Controllers;

use App\Core\Iterator;
use App\Models\Consulta;
use App\Models\Medico;
use App\Models\Morada;
use App\Models\Receita;
use App\Models\Utente;
use CodeIgniter\I18n\Time;
use CodeIgniter\Pager\Pager;
use CodeIgniter\View\Table;

class Listar extends BaseController{
    private string $perPageName = 'quantity';
    protected $helpers = ['table', 'form'];

    public function medicos(): string{
        $model = model(Medico::class);
        return $this->loadTrabalhador($model->paginate($this->request->getGet($this->perPageName) ?? 10), $model->pager, [
            'title' => 'Medicos',
            'styles' => [base_url('css/menu.css'), base_url('css/login.css'),base_url('css/home.css'),base_url('css/pagination.css'),base_url('css/tables.css'), base_url('css/form.css')]
        ]);
    }


    public function utentes(): string{
        $model = model(\App\Models\Utente::class);
        return $this->list($model->paginate($this->request->getGet($this->perPageName) ?? 10), $model->pager,
            [
                'id' => 'Id',
                'nome' => 'Nome',
                'numeroUtente' => 'Numero de Utente',
                'morada' => 'Morada',
                'codigoPostal' => 'Codigo Postal',
                'codigoPostal->localidade' => 'Cidade',
                'codigoPostal->concelho' => 'Concelho',
                'codigoPostal->distrito' => 'Distrito'
            ],
            [
                'nome' => 'Nome',
                'localidade' => 'Cidade'
            ],
            [
                'title' => 'Utentes',
                'styles' => [base_url('css/menu.css'), base_url('css/login.css'),base_url('css/home.css'),base_url('css/pagination.css'),base_url('css/tables.css'), base_url('css/form.css')]
            ]
        );
    }

    public function enfermeiros(): string{
        $model = model(\App\Models\Enfermeiro::class);
        return $this->loadTrabalhador($model->paginate($this->request->getGet($this->perPageName) ?? 10), $model->pager, [
            'title' => 'Enfermeiros',
            'styles' => [base_url('css/menu.css'), base_url('css/login.css'),base_url('css/home.css'),base_url('css/pagination.css'),base_url('css/tables.css'), base_url('css/form.css')]
        ]);
    }

    public function consultas(){
        $model = model(Consulta::class);
        $medicoModel = model(Medico::class);
        $utenteModel = model(Utente::class);
        $receitaModel = model(Receita::class);
        $filters = null;
        if(!$this->isLoggedIn())
            $model->where('data >=', Time::createFromTime(00, 00, 00))->where('data <=', Time::createFromTime(23, 59, 59));
        else{
            $nameFrom = 'from';
            $nameTo = 'to';

            $filters = form_open('', ['method' => 'GET']) .
                form_label('De: ', $nameFrom) .
                form_input($nameFrom, $this->request->getGet($nameFrom) ?? '', ['id' => $nameFrom], 'datetime-local') .
                form_label('Até: ', $nameTo) .
                form_input($nameTo, $this->request->getGet($nameTo) ?? '', ['id' => $nameTo], 'datetime-local') .
                form_submit('submit', 'Carregar') .
                form_close();
                $from = $this->request->getGet($nameFrom);
                $to = $this->request->getGet($nameTo);
                if($t = strtotime($from))
                    $model->where('data >=', Time::createFromTimestamp($t));
                if($t = strtotime($to))
                    $model->where('data <=', Time::createFromTimestamp($t));
        }
        $list = $model->paginate($this->request->getGet($this->perPageName) ?? 10);
        for($it = new Iterator($list);!$it->isDone();$it->next()){
            $atual = $it->current();
            $nomes = ['utente' => $utenteModel, 'medico' => $medicoModel, 'receita' => $receitaModel];
            for($it2 = new Iterator($nomes);!$it2->isDone();$it2->next()){
                $ret = $it2->current()->findById($atual->{$it2->key()}->id ?? 0);
                if(!$ret){
                    $class = 'App\Entities\\' . ucfirst($it2->key());
                    $ret = new $class();
                    $ret->id = (string)$atual->{$it2->key()};
                }
                $atual->{$it2->key()} = $ret;
            }
        }
        return $this->list($list, $model->pager, ['id' => 'Id', 'medico->nome' => 'Medico', 'utente->nome' => 'Utente', '<a href="'.url_to('consulta',0).'{{id}}">Detalhes</a>' => 'Detalhes'], ['medico->nome' => 'Medico', 'utente->nome' => 'Utente'], ['title' => 'Consultas', 'styles' => [base_url('css/menu.css'), base_url('css/login.css'),base_url('css/home.css'),base_url('css/pagination.css'),base_url('css/tables.css'), base_url('css/form.css')]], $filters);
    }


    private
    function loadTrabalhador(array $list, Pager $pager, array $header){

        return $this->list($list, $pager,
            [
                'id' => 'Id',
                'nome' => 'Nome',
                'nif' => 'NIF',
                'nib' => 'NIB',
                'especialidade' => 'Especialidade',
                'morada' => 'Morada',
                'codigoPostal->codigoPostal' => 'Codigo Postal',
                'codigoPostal->localidade' => 'Cidade',
                'codigoPostal->concelho' => 'Concelho',
                'codigoPostal->distrito' => 'Distrito'
            ],
            [
                'nome' => 'Nome',
                'especialidade' => 'Especialidade'
            ],
            $header
        );
    }

    private
    function list(array $list, Pager $pager, array $loggedIn, array $notLoggedIn, array $header, ?string $filters = null): string{
        for($it = new Iterator($list);!$it->isDone();$it->next()){
            if(!isset($it->current()->codigoPostal))
                continue;
            $model = model(Morada::class);
            if($morada = ($model->findByCodigoPostal($it->current()->codigoPostal->codigoPostal)))
                $it->current()->codigoPostal = $morada;
        }

        $table = empty($list) ? null : assocToTable($this->isLoggedIn() ? $loggedIn : $notLoggedIn, $list)->generate();
        return $this->loadDefaultView(['page' => 'listagem/template_tabela', 'data' => ['table' => $table, 'pager' => $pager, 'filters' => $filters, 'errors' => session()->getFlashdata('err')]], $header);
    }
}

?>