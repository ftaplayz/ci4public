<?php
namespace App\Models;

use CodeIgniter\Model;

class Utilizador extends Model {
    protected $table = 'utilizador';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = \App\Entities\Utilizador::class;
    protected $allowedFields = ['id','utilizador', 'password', 'medico', 'ativo', 'token'];
    protected $validationRules = [
        'utilizador' => 'required|max_length[20]|alpha_numeric|min_length[3]|is_unique[utilizador.utilizador]',
        'password' => 'required',
        'medico' => 'is_bool',
        'ativo' => 'is_bool',
        'token' => 'required|exact_length[100]'
    ];
    private $phpPass;
    
    public function initialize(){
        $config = config('PHPass')->utilizadores;
        $this->phpPass = new \App\Libraries\PasswordHash($config['iteration_count_log2'], $config['portable_hashes']);
    }

    public function findUserByUsername(string $user): ?object{
        return $this->where('utilizador', $user)->first();
    }

    public function verifyPassword(string $password, string $hashedPassword): bool{
        return $this->phpPass->CheckPassword($password, $hashedPassword);
    }

    public function newUser(\App\Entities\Utilizador &$user){
        $user->id = $this->insert($user, true);
    }

    public function findUserById(int $id): ?object{
        return $this->find($id);
    }

    public function updateUser(\App\Entities\Utilizador $user): bool{
        return $this->update($user->id, $user);
    }
}
?>