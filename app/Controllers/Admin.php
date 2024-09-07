<?php

namespace App\Controllers;


use App\Models\Consulta;
use App\Models\Medico;
use CodeIgniter\Pager\Pager;

class Admin extends BaseController{
    private string $perPageName = 'quantity';
    protected $helpers = ['table'];

    public function medico(){
        if(!$this->isLoggedIn())
            return redirect()->route('home');
        $model = model(Medico::class);
        return $this->loadTrabalhador($model->paginate($this->request->getGet($this->perPageName) ?? 10), $model->pager, service('router')->methodName(), [
            'title' => 'Editar medicos'
        ]);
    }


    public function utente(){
        if(!$this->isLoggedIn())
            return redirect()->route('home');
        $model = model(\App\Models\Utente::class);
        $method = service('router')->methodName();
        return $this->list($model->paginate($this->request->getGet($this->perPageName) ?? 10), $model->pager,
            [
                'id' => 'Id',
                'nome' => 'Nome',
                'numeroUtente' => 'Numero de Utente',
                'morada' => 'Morada',
                'codigoPostal' => 'Codigo Postal',
                '<a href="' . url_to('adminEdit', $method, 0) . '{{id}}">Editar</a>' => 'Editar',
                '<a href="' . url_to('adminDelete', $method, 0) . '{{id}}">Eliminar</a>' => 'Eliminar'
            ],
            [
                'title' => 'Editar utentes'
            ],
        );
    }

    public function morada(){
        if(!$this->isLoggedIn())
            return redirect()->route('home');
        $model = model(\App\Models\Morada::class);
        $method = service('router')->methodName();
        return $this->list($model->paginate($this->request->getGet($this->perPageName) ?? 10), $model->pager,
            [
                'codigo_postal' => 'Codigo Postal',
                'localidade' => 'Localidade',
                'concelho' => 'Concelho',
                'distrito' => 'Distrito',
                '<a href="' . url_to('adminEdit', $method, 0) . '{{codigo_postal}}">Editar</a>' => 'Editar',
                '<a href="' . url_to('adminDelete', $method, 0) . '{{codigo_postal}}">Eliminar</a>' => 'Eliminar'
            ],
            [
                'title' => 'Editar moradas'
            ],
        );
    }

    public function produto(){
        if(!$this->isLoggedIn())
            return redirect()->route('home');
        $model = model(\App\Models\Produto::class);
        $method = service('router')->methodName();
        return $this->list($model->paginate($this->request->getGet($this->perPageName) ?? 10), $model->pager,
            [
                'id' => 'ID',
                'nome' => 'Nome',
                'imagem' => 'Imagem',
                '<a href="' . url_to('adminEdit', $method, 0) . '{{id}}">Editar</a>' => 'Editar',
                '<a href="' . url_to('adminDelete', $method, 0) . '{{id}}">Eliminar</a>' => 'Eliminar'
            ],
            [
                'title' => 'Editar produtos'
            ],
        );
    }

    public function receita(){
        if(!$this->isLoggedIn())
            return redirect()->route('home');
        $model = model(\App\Models\Receita::class);
        $method = service('router')->methodName();
        return $this->list($model->paginate($this->request->getGet($this->perPageName) ?? 10), $model->pager,
            [
                'id' => 'ID',
                'utilizacao' => 'Utilização',
                'receita_pdf' => 'PDF da Receita',
                '<a href="' . url_to('adminEdit', $method, 0) . '{{id}}">Editar</a>' => 'Editar',
                '<a href="' . url_to('adminDelete', $method, 0) . '{{id}}">Eliminar</a>' => 'Eliminar'
            ],
            [
                'title' => 'Editar receitas'
            ],
        );
    }

    public function contacto(){
        if(!$this->isLoggedIn())
            return redirect()->route('home');
        $model = model(\App\Models\Contacto::class);
        $method = service('router')->methodName();
        return $this->list($model->paginate($this->request->getGet($this->perPageName) ?? 10), $model->pager,
            [
                'registo' => 'Data de Registo',
                'ativo' => 'Por resolver',
                '<a href="' . url_to('adminEdit', $method, 0) . '{{id}}">Editar</a>' => 'Editar',
                '<a href="' . url_to('adminDelete', $method, 0) . '{{id}}">Eliminar</a>' => 'Eliminar'
            ],
            [
                'title' => 'Editar contactos'
            ],
        );
    }

    public function enfermeiro(){
        if(!$this->isLoggedIn())
            return redirect()->route('home');
        $model = model(\App\Models\Enfermeiro::class);
        return $this->loadTrabalhador($model->paginate($this->request->getGet($this->perPageName) ?? 10), $model->pager, service('router')->methodName(), [
            'title' => 'Editar enfermeiros'
        ]);
    }

    public function consulta(){
        if(!$this->isLoggedIn())
            return redirect()->route('home');
        $method = service('router')->methodName();
        $model = model(Consulta::class);
        $list = $model->paginate($this->request->getGet($this->perPageName) ?? 10);
        return $this->list($list, $model->pager, ['id' => 'Id', 'data' => 'Data', 'medico' => 'Id Medico', 'utente' => 'Id Utente', 'receita' => 'Id Receita',
            '<a href="' . url_to('adminEdit', $method, 0) . '{{id}}">Editar</a>' => 'Editar',
            '<a href="' . url_to('adminDelete', $method, 0) . '{{id}}">Eliminar</a>' => 'Eliminar'], ['title' => 'Editar consultas']);
    }


    private function loadTrabalhador(array $list, Pager $pager, string $method, array $header){
        return $this->list($list, $pager,
            [
                'id' => 'Id',
                'nome' => 'Nome',
                'nif' => 'NIF',
                'nib' => 'NIB',
                'especialidade' => 'Especialidade',
                'morada' => 'Morada',
                'codigoPostal' => 'Codigo Postal',
                '<a href="' . url_to('adminEdit', $method, 0) . '{{id}}">Editar</a>' => 'Editar',
                '<a href="' . url_to('adminDelete', $method, 0) . '{{id}}">Eliminar</a>' => 'Eliminar'

            ],
            $header
        );
    }

    private function list(array $list, Pager $pager, array $table, array $header): string{
        $table = empty($list) ? null : assocToTable($table, $list)->generate();
        $header['styles'] = [base_url('css/menu.css'), base_url('css/home.css'), base_url('css/form.css'), base_url('css/tables.css'), base_url('css/pagination.css')];
        return $this->loadDefaultView(['page' => 'listagem/template_tabela', 'data' => ['table' => $table, 'pager' => $pager, 'errors' => session()->getFlashdata('err'), 'admin' => true]], $header, 'admin/menu');
    }
}

?>