<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class ProdutosGaleriaModel extends Model {

    protected $table = 'produtos_galeria';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'cod_sinc', 'produtos_id', 'imagem', 'ordem', 'cor'
    ];
    protected $useAutoIncrement = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

}
