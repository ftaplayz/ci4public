<?php

namespace App\Controllers;

use App\Models\Morada;
use App\Models\Produto;
use App\Models\Receita;
use App\Models\Utente;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Core\Iterator;
use App\Models\Consulta;
use App\Models\Medico;

use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;

use function PHPUnit\Framework\containsEqual;

use App\Models\Enfermeiro;

class Crud extends BaseController{
    protected $helpers = ['form'];

    public function delete(string $method, int $id){
        $model = model('\App\Models\\' . ucfirst($method));
        $model->delete($id);
        return redirect()->back();
    }

    public function create(string $method){
        return $this->edit($method);
    }

    public function edit(string $method, ?int $id = null){
        if(!$this->isLoggedIn())
            return redirect()->route('home');
        $form = null;
        $methodName = $method . 'Form';
        if(method_exists($this, $methodName))
            $form = $this->{$methodName}($id);
        else
            throw PageNotFoundException::forPageNotFound();
        return $this->loadDefaultView(['page' => 'admin/form', 'data' => ['form' => $form['form'], 'errors' => $form['errors'], 'entity' => $method, 'id' => $id]], ['title' => $method, 'styles' => [base_url('css/menu.css'), base_url('css/home.css'), base_url('css/crud.css')]], 'admin/menu');
    }

    private function consultaForm(?int $id = null){
        $model = model(Consulta::class);
        $consulta = null;
        if(!empty($id))
            if(empty($consulta = $model->findById($id, true)))
                throw PageNotFoundException::forPageNotFound();
        $data = [
            'data' => [
                'label' => 'Data da consulta',
                'name' => 'data',
                'id' => 'dataid',
                'type' => 'datetime-local',
                'value' => '',
                'required' => 'required'
            ],
            'estado' => [
                'label' => 'Estado',
                'name' => 'estado',
                'id' => 'estadoid',
                'type' => 'checkbox'
            ],
            'medico' => [
                'label' => 'ID do Medico',
                'name' => 'medico',
                'id' => 'medicoid',
                'type' => 'number',
                'step' => 1,
                'value' => 1,
                'min' => 1,
                'required' => 'required'
            ],
            'utente' => [
                'label' => 'ID do Utente',
                'name' => 'utente',
                'id' => 'utenteid',
                'type' => 'number',
                'step' => 1,
                'value' => 1,
                'min' => 1,
                'required' => 'required'
            ],
            'receita' => [
                'label' => 'ID da Receita',
                'name' => 'receita',
                'id' => 'receitaid',
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'value' => 1,
                'required' => 'required'
            ],
            'enfermeiros' => [
                'label' => 'ID(s) dos enfermeiros',
                'name' => 'enfermeiros',
                'id' => 'enfermeiros',
                'type' => 'text',
                'value' => '',
                'placeholder' => '1,2,3,4'
            ],
            'submit' => [
                'value' => isset($id) && $id != 0 ? 'Editar' : 'Criar',
                'name' => 'submit',
                'type' => 'submit'
            ]
        ];
        if($this->request->getMethod() == 'post'){
            $consulta = new \App\Entities\Consulta($this->request->getPost());
            $enfermeiros = explode(',', $this->request->getPost($data['enfermeiros']['name']));
            $consulta->enfermeiros = $enfermeiros;
            $consulta->estado = array_key_exists($data['estado']['name'], $this->request->getPost());
            if(empty($id))
                $model->create($consulta);
            else{
                $consulta->id = $id;
                $model->edit($consulta);
            }
        }
        $this->setValues($data, $consulta);
        $form = $this->createForm($data);
        return ['form' => $form, 'errors' => $model->errors()];
    }

    private function enfermeiroForm(?int $id = null){
        $model = model(Enfermeiro::class);
        $enfermeiro = null;
        if(!empty($id))
            if(empty($enfermeiro = $model->findById($id)))
                throw PageNotFoundException::forPageNotFound();
        $data = [
            'nome' => [
                'name' => 'nome',
                'id' => 'nome',
                'type' => 'text',
                'value' => '',
                'required' => 'required'
            ],
            'nif' => [
                'name' => 'nif',
                'id' => 'nif',
                'type' => 'number',
                'step' => 1,
                'value' => '',
                'required' => 'required'
            ],
            'nib' => [
                'name' => 'nib',
                'id' => 'nib',
                'type' => 'number',
                'value' => '',
                'step' => 1,
                'required' => 'required'
            ],
            'especialidade' => [
                'name' => 'especialidade',
                'id' => 'especialidade',
                'value' => '',
                'type' => 'text',
                'required' => 'required'
            ],
            'morada' => [
                'name' => 'morada',
                'id' => 'morada',
                'value' => '',
                'type' => 'text',
                'required' => 'required'
            ],
            'codigoPostal' => [
                'name' => 'codigo_postal',
                'id' => 'codigo_postal',
                'type' => 'number',
                'step' => 1,
                'required' => 'required'
            ],
            'submit' => [
                'value' => isset($id) && $id != 0 ? 'Editar' : 'Criar',
                'name' => 'submit',
                'type' => 'submit'
            ]
        ];

        if($this->request->getMethod() == 'post'){

            $enfermeiro = new \App\Entities\Enfermeiro($this->request->getPost());
            if(empty($id))
                $model->create($enfermeiro);
            else{
                $enfermeiro->id = $id;
                $model->edit($enfermeiro);
            }

        }
        $this->setValues($data, $enfermeiro);
        $form = form_open();
        $form .= form_label('Nome', $data['nome']['id']);
        $form .= form_input($data['nome']);
        $form .= form_label('NIF', $data['nif']['id']);
        $form .= form_input($data['nif']);

        $form .= form_label('NIB', $data['nib']['id']);
        $form .= form_input($data['nib']);

        $form .= form_label('Especialidade', $data['especialidade']['id']);
        $form .= form_input($data['especialidade']);

        $form .= form_label('Morada', $data['morada']['id']);
        $form .= form_input($data['morada']);

        $form .= form_label('Codigo Postal', $data['codigoPostal']['id']);
        $form .= form_input($data['codigoPostal']);

        $form .= form_input($data['submit']);
        $form .= form_close();
        return ['form' => $form, 'errors' => $model->errors()];
    }

    private function utenteForm(?int $id = null){
        $model = model(Utente::class);
        $utente = null;
        if(!empty($id))
            if(empty($utente = $model->findById($id)))
                throw PageNotFoundException::forPageNotFound();
        $data = [
            'nome' => [
                'label' => 'Nome',
                'name' => 'nome',
                'id' => 'nome',
                'type' => 'text',
                'value' => '',
                'required' => 'required'
            ],
            'numeroUtente' => [
                'label' => 'Numero de Utente',
                'name' => 'numero_utente',
                'id' => 'numero_utente',
                'type' => 'number',
                'step' => 1,
                'value' => '',
                'required' => 'required'
            ],
            'morada' => [
                'label' => 'Morada',
                'name' => 'morada',
                'id' => 'morada',
                'value' => '',
                'type' => 'text',
                'required' => 'required'
            ],
            'codigoPostal' => [
                'label' => 'Codigo Postal',
                'name' => 'codigo_postal',
                'id' => 'codigo_postal',
                'type' => 'number',
                'step' => 1,
                'required' => 'required'
            ],
            'submit' => [
                'value' => isset($id) && $id != 0 ? 'Editar' : 'Criar',
                'name' => 'submit',
                'type' => 'submit'
            ]
        ];

        if($this->request->getMethod() == 'post'){

            $utente = new \App\Entities\Utente($this->request->getPost());
            if(empty($id))
                $model->create($utente);
            else{
                $utente->id = $id;
                $model->edit($utente);
            }

        }
        $this->setValues($data, $utente);
        $form = $this->createForm($data);
        return ['form' => $form, 'errors' => $model->errors()];
    }

    private function medicoForm(?int $id = null){
        $model = model(Medico::class);
        $medico = null;
        if(!empty($id))
            if(empty($medico = $model->findById($id)))
                throw PageNotFoundException::forPageNotFound();
        $data = [
            'nome' => [
                'label' => 'Nome',
                'name' => 'nome',
                'id' => 'nome',
                'type' => 'text',
                'value' => '',
                'required' => 'required'
            ],
            'nif' => [
                'label' => 'NIF',
                'name' => 'nif',
                'id' => 'nif',
                'type' => 'number',
                'step' => 1,
                'value' => '',
                'required' => 'required'
            ],
            'nib' => [
                'label' => 'NIB',
                'name' => 'nib',
                'id' => 'nib',
                'type' => 'number',
                'step' => 1,
                'required' => 'required'
            ],
            'especialidade' => [
                'label' => 'Especialidade',
                'name' => 'especialidade',
                'id' => 'especialidade',
                'type' => 'text',
                'required' => 'required'
            ],
            'morada' => [
                'label' => 'Morada',
                'name' => 'morada',
                'id' => 'morada',
                'type' => 'text',
                'required' => 'required'
            ],
            'codigoPostal' => [
                'label' => 'Codigo Postal',
                'name' => 'codigo_postal',
                'id' => 'codigo_postal',
                'type' => 'number',
                'step' => 1,
                'required' => 'required'
            ],
            'submit' => [
                'value' => isset($id) && $id != 0 ? 'Editar' : 'Criar',
                'name' => 'submit',
                'type' => 'submit'
            ]
        ];

        if($this->request->getMethod() == 'post'){
            $medico = new \App\Entities\Medico($this->request->getPost());
            if(empty($id))
                $model->create($medico);
            else{
                $medico->id = $id;
                $model->edit($medico);
            }

        }
        $this->setValues($data, $medico);
        $form = $this->createForm($data);
        return ['form' => $form, 'errors' => $model->errors()];
    }

    private function moradaForm(?int $id = null){
        $model = model(Morada::class);
        $morada = null;
        if(!empty($id))
            if(empty($morada = $model->findById($id)))
                throw PageNotFoundException::forPageNotFound();
        $data = [
            'codigo_postal' => [
                'label' => 'Codigo Postal',
                'name' => 'codigo_postal',
                'id' => 'codigo_postal',
                'type' => 'number',
                'step' => 1,
                'value' => '',
                'required' => 'required'
            ],
            'localidade' => [
                'label' => 'Localidade',
                'name' => 'localidade',
                'id' => 'localidade',
                'type' => 'text',
                'value' => '',
                'required' => 'required'
            ],
            'concelho' => [
                'label' => 'Concelho',
                'name' => 'concelho',
                'id' => 'concelho',
                'type' => 'text',
                'value' => '',
                'required' => 'required'
            ],
            'distrito' => [
                'label' => 'Distrito',
                'name' => 'distrito',
                'id' => 'distrito',
                'value' => '',
                'type' => 'text',
                'required' => 'required'
            ],
            'submit' => [
                'value' => isset($id) && $id != 0 ? 'Editar' : 'Criar',
                'name' => 'submit',
                'type' => 'submit'
            ]
        ];

        if($this->request->getMethod() == 'post'){
            $morada = new \App\Entities\Morada($this->request->getPost());
            if(empty($id))
                $model->create($morada);
            else{
                $morada->id = $id;
                $model->edit($morada);
            }
        }
        $this->setValues($data, $morada);
        $form = $this->createForm($data);
        return ['form' => $form, 'errors' => $model->errors()];
    }

    private function produtoForm(?int $id = null){

        $model = model(Produto::class);
        $produto = null;
        if(!empty($id))
            if(empty($produto = $model->findById($id)))
                throw PageNotFoundException::forPageNotFound();
        $data = [
            'nome' => [
                'label' => 'Nome',
                'name' => 'nome',
                'id' => 'nome',
                'type' => 'text',
                'value' => '',
                'required' => 'required'
            ],
            'imagem' => [
                'label' => 'Imagem',
                'name' => 'imagem',
                'id' => 'imagem',
                'type' => 'file',
                'value' => ''
            ],
            'submit' => [
                'value' => isset($id) && $id != 0 ? 'Editar' : 'Criar',
                'name' => 'submit',
                'type' => 'submit'
            ]
        ];
        $val = null;
        if($this->request->getMethod() == 'post'){
            if($this->validate(['imagem' => "is_image[imagem]|max_size[imagem, 5120]"])){
                $produto = new \App\Entities\Produto($this->request->getPost());
                if(($img = $this->request->getFile($data['imagem']['name']))->getSize()>0){
                    $nome = $img->getRandomName();
                    $img->move('uploads/produtos', $nome);
                    $produto->imagem = base_url('uploads/produtos/' . $nome);
                }
                if(empty($id))
                    $model->create($produto);
                else{
                    $produto->id = $id;
                    $model->edit($produto);
                }
            }else
                $val = 'O ficheiro não é uma imagem ou excede os limites de tamanho (5MB)';
        }
        $this->setValues($data, $produto);
        $form = $this->createForm($data, true);
        $err = $model->errors();
        if(isset($val))
            $err[] = $val;
        return ['form' => $form, 'errors' => $err];
    }

    private function contactoForm(?int $id = null){
        $model = model(\App\Models\Contacto::class);
        $contacto = null;
        if(!empty($id))
            if(empty($contacto = $model->findById($id)))
                throw PageNotFoundException::forPageNotFound();
        $data = [
            'registo' => [
                'label' => 'Registo',
                'name' => 'registo',
                'id' => 'registo',
                'value' => '',
                'type' => 'datetime-local'
            ],
            'ativo' => [
                'label' => 'Por resolver',
                'name' => 'ativo',
                'id' => 'ativo',
                'value' => '',
                'type' => 'checkbox'
            ],
            'submit' => [
                'value' => isset($id) && $id != 0 ? 'Editar' : 'Criar',
                'name' => 'submit',
                'type' => 'submit'
            ]
        ];

        if($this->request->getMethod() == 'post'){
            $contacto = new \App\Entities\Contacto($this->request->getPost());
            $contacto->ativo = array_key_exists($data['ativo']['name'], $this->request->getPost());
            if(empty($id))
                $model->create($contacto);
            else{
                $contacto->id = $id;
                $model->edit($contacto);
            }
        }
        $this->setValues($data, $contacto);
        $form = $this->createForm($data);
        return ['form' => $form, 'errors' => $model->errors()];
    }

    private function receitaForm(?int $id = null){
        $model = model(Receita::class);
        $receita = null;
        if(!empty($id))
            if(empty($receita = $model->findById($id, true)))
                throw PageNotFoundException::forPageNotFound();
        $data = [
            'utilizacao' => [
                'label' => 'Utilização',
                'name' => 'utilizacao',
                'id' => 'utilizacao',
                'type' => 'text',
                'value' => '',
                'required' => 'required'
            ],
            'receita_pdf' => [
                'label' => 'PDF da Receita',
                'name' => 'receita_pdf',
                'id' => 'receita_pdf',
                'type' => 'file'
            ],
            'produtos' => [
                'label' => 'ID(s) do(s) Produto(s)',
                'name' => 'produtos',
                'id' => 'produtos',
                'type' => 'text',
                'value' => '',
                'placeholder' => '1,2,3,4',
                'required' => 'required'
            ],
            'submit' => [
                'value' => isset($id) && $id != 0 ? 'Editar' : 'Criar',
                'name' => 'submit',
                'type' => 'submit'
            ]
        ];
        $val = null;
        if($this->request->getMethod() == 'post'){
            if($this->validate(['receita_pdf' => "max_size[receita_pdf, 5020]|mime_in[receita_pdf,application/pdf]"])){
                $oldReceita = $receita;
                $receita = new \App\Entities\Receita($this->request->getPost());
                $produtos = explode(',', $this->request->getPost($data['produtos']['name']));
                if(($img = $this->request->getFile($data['receita_pdf']['name']))->getSize()>0){
                    $nome = $img->getRandomName();
                    $img->move('uploads/receitas', $nome);
                    $receita->receitaPdf = base_url('uploads/receitas/' . $nome);
                }
                $receita->produtos = $produtos;
                if(empty($id))
                    $model->create($receita);
                else{
                    $receita->id = $id;
                    $model->edit($receita);
                }
            }else
                $val = 'O ficheiro não é um PDF ou excede os limites de tamanho (5MB)';
        }
        $this->setValues($data, $receita);
        $form = $this->createForm($data, true);
        $err = $model->errors();
        if(isset($val))
            $err[] = $val;
        return ['form' => $form, 'errors' => $err];
    }

    private function setValues(&$data, $obj){
        for($it = new Iterator($data);!$it->isDone();$it->next()){
            $key = $it->key();
            $value = $it->current();

            switch($value['type']){
                case 'checkbox':
                    if(!empty(set_checkbox($value['name'])) || !empty($obj->{$key}))
                        $data[$key]['checked'] = 'checked';
                    break;
                default:
                    $data[$key]['value'] = !empty(set_value($value['name'])) ? set_value($value['name']) : (!empty($obj->{$key}) ? (gettype($obj->{$key}) == 'array' ? implode(',', $obj->{$key}) : $obj->{$key}) : ($value['value'] ?? ''));

            }

        }
    }

    private function createForm(array &$data, bool $multipart = false){
        $form = $multipart ? form_open_multipart() : form_open();
        for($it = new Iterator($data);!$it->isDone();$it->next()){
            $key = $it->key();
            $value = $it->current();
            if(array_key_exists('label', $value)){
                $form .= form_label($value['label'], $value['id']);
                unset($value['label']);
            }
            $form .= form_input($value);
        }
        return $form . form_close();
    }
}

?>