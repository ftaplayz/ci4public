<?php
namespace App\Models;

use App\Entities\Medico as MedicoEntity;

class Medico extends BaseTrabalhador {
    protected $table = 'medico';
    protected $returnType = MedicoEntity::class;
}
?>