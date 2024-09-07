<?php

namespace App\Controllers;

use CodeIgniter\CodeIgniter;
use \App\Libraries\EmailSender;
use CodeIgniter\I18n\Time;

class Contacto extends BaseController{
    public function index(): string{
        helper(['form', 'validation']);
        $form = [
            'email' => [
                'data' => [
                    'type' => 'email',
                    'required' => 'required',
                    'name' => 'email',
                    'id' => 'email',
                    'placeholder' => 'exemplo@exemplo.com'
                ],
                'label' => 'O seu email',
            ],
            'subject' => [
                'data' => [
                    'type' => 'text',
                    'maxlength' => 988,
                    'minlength' => 5,
                    'required' => 'required',
                    'name' => 'motivo',
                    'id' => 'subject'
                ],
                'label' => 'Motivo'
            ],
            'textarea' => [
                'data' => [
                    'required' => 'required',
                    'placeholder' => 'Aqui vai a mensagem para enviar',
                    'name' => 'mensagem',
                    'id' => 'content'
                ],
                'label' => 'Conteudo do email'
            ],
            'submit' => [
                'data' => [
                    'name' => 'submit',
                    'value' => 'Submeter'
                ]

            ]
        ];
        if($this->request->getMethod() == 'post'){
            if(!$this->validateData([$form['email']['data']['name'] => $this->request->getPost($form['email']['data']['name']), $form['subject']['data']['name'] => $this->request->getPost($form['subject']['data']['name']), $form['textarea']['data']['name'] => $this->request->getPost($form['textarea']['data']['name'])], [$form['email']['data']['name'] => htmlRulesToCI($form['email']['data']), $form['subject']['data']['name'] => htmlRulesToCI($form['subject']['data']), $form['textarea']['data']['name'] => htmlRulesToCI($form['textarea']['data'])]))
                $form['errors'] = validation_list_errors();
            else{
                helper('captcha');
                if(passedReCaptcha('6Le9bRwpAAAAAD9_jhII8j1ON7QMffg3DRpXORJV', $this->request->getPost('g-recaptcha-response'))){
                    $mail = new EmailSender();
                    $contactoEntity = new \App\Entities\Contacto();
                    $contactoEntity->registo = Time::now();
                    $contactoEntity->ativo = true;
                    $contacto = model(\App\Models\Contacto::class);
                    $contacto->newContacto($contactoEntity);
                    if($contactoEntity->id){
                        $userEmail = $this->request->getPost($form['email']['data']['name']);
                        $msgReason = $this->request->getPost($form['subject']['data']['name']);
                        $msgContent = $this->request->getPost($form['textarea']['data']['name']);
                        $htmlMsg = "<h1>Ticket id: {$contactoEntity->id}</h1><br />
                    <div><p>Aberto por $userEmail às {$contactoEntity->registo}</p></div>
                    <div><p><strong>Motivo:</strong> $msgReason</p><p><strong>Conteudo: </strong>$msgContent</p></div>
                    <p>Pode demorar até 3 dias uteis para receber uma resposta. Caso tenha mais informações responda a este endereço eletrónico.</p>";
                        $msg = strip_tags($htmlMsg);
                        $form['sucesso'] = $mail->sendEmail('Info contacto', [$userEmail, $mail->getSender()], 'Ticket de contacto id: ' . $contactoEntity->id, ['msg' => $msg, 'html' => $htmlMsg]);
                    }
                }else
                    $form['errors'] = 'Captcha incorreto';

            }
        }
        return $this->loadDefaultView(['page' => 'contactos', 'data' => $form], ['title' => 'Contacto', 'styles' => [base_url('css/menu.css'), base_url('css/form.css'), base_url('css/home.css')], 'scripts' => [
            ['src' => 'https://www.google.com/recaptcha/api.js', 'params' => 'async defer']
        ]]);
    }
}

?>