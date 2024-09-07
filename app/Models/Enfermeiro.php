<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Enfermeiro as EnfermeiroEntity;

class Enfermeiro extends BaseTrabalhador {
    protected $table = 'enfermeiro';
    protected $returnType = EnfermeiroEntity::class;
}
?>