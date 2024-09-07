<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Configuração para PHPass
 * uma variavel por configuração
 * reutilizar diferentes configurações
 * em diferentes lugares
 */
class PHPass extends BaseConfig{
    /**
     * Exemplo de configuração para
     * hash de utilizadores em
     * base de dados e entidade
     * 
     */
    public array $utilizadores = [
        'iteration_count_log2' => 8, 'portable_hashes' => false
    ];
}
?>