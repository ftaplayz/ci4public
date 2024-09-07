<?php

namespace App\Controllers;

class Autenticacao extends BaseController{
    public function login(){
        if($this->isLoggedIn())
            return redirect()->route('adminMedicos');

        helper('form');
        $info = [
            'user' => [
                'data' => [
                    'id' => 'user',
                    'name' => 'utilizador',
                    'placeholder' => 'Digite o seu utilizador',
                    'minlength' => 3,
                    'maxlength' => 20,
                    'required' => 'required'
                ],
                'label' => 'Utilizador'
            ],
            'password' => [
                'data' => [
                    'id' => 'pass',
                    'name' => 'password',
                    'placeholder' => 'Digita a sua palavra-passe',
                    'required' => 'required'
                ],
                'label' => 'Palavra-passe'
            ],
            'submit' => [
                'data' => [
                    'name' => 'submit',
                    'value' => 'Login'
                ]
            ]
        ];


        if($this->request->getMethod() == 'post'){
            helper('captcha');
            if(passedReCaptcha('6Le9bRwpAAAAAD9_jhII8j1ON7QMffg3DRpXORJV', $this->request->getPost('g-recaptcha-response'))){
                $userModel = model('Utilizador');
                $utilizador = $userModel->findUserByUsername($this->request->getPost($info['user']['data']['name']));
                if($utilizador && $userModel->verifyPassword($this->request->getPost($info['password']['data']['name']), $utilizador->password)){
                    $rand = bin2hex(random_bytes(50));
                    if($utilizador->token != $rand){
                        $utilizador->token = $rand;
                        $userModel->updateUser($utilizador);
                    }
                    session()->set('userdata', serialize($utilizador));
                    return redirect()->route('adminMedicos');
                }
                $info['error'] = 'Dados incorretos';
            }else
                $info['error'] = 'Captcha incorreto';

        }
        return $this->loadDefaultView(
            [
                'page' => 'autenticacao/login',
                'data' => $info
            ],
            [
                'title' => 'Login',
                'styles' => [base_url('css/menu.css'), base_url('css/login.css'),base_url('css/home.css'), base_url('css/form.css')],
                'scripts' => [
                    ['src' => 'https://www.google.com/recaptcha/api.js', 'params' => 'async defer']
                ]
            ]
        );
    }
}

?>