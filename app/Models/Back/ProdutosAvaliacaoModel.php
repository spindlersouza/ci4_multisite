<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class ProdutosAvaliacaoModel extends Model {

    protected $table = 'produtos_avaliacao';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'cliente_id', 'produtos_id', 'nota', 'descricao', 'ativo'
    ];
    protected $useAutoIncrement = true;
    protected $createdField = 'created_at';
    

}
