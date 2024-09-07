<?php
namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Utilizador extends BaseEntity {
    protected $attributes = [
        'id' => null,
        'utilizador' => null,
        'password' => null,
        'medico' => null,
        'ativo' => 1,
        'token' => null
    ];

    protected $casts = [
        'utilizador' => 'string',
        'password' => 'string',
        'medico' => 'boolean',
        'ativo' => 'boolean',
        'token' => 'string'
    ];

    public function setPassword(string $pass): Utilizador{
        $config = config('PHPass')->utilizadores;
        $this->attributes['password'] = (new \App\Libraries\PasswordHash($config['iteration_count_log2'], $config['portable_hashes']))->HashPassword($pass);
        return $this;
    }

    public function setToken(string $token): Utilizador{
        $this->attributes['token'] = $token;
        return $this;
    }

    public function __toString(){
        return $this->attributes['id'] ?? 0;
    }

}
?>