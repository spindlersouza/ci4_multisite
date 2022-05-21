<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class ProdutosAtributosModel extends Model {

    protected $table = 'produtos_atributos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'cod_sinc', 'produtos_id', 'produtos_tipo_atributos_id', 'produtos_valor_atributos_id', 'peso', 'ativo', 'created_usuario_id', 'created_at', 'updated_at'
    ];
    protected $useAutoIncrement = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $skipValidation = false;
    protected $validationRules = [
        'cod_sinc' => 'required',
        'peso' => 'required',
        'ativo' => 'required',
    ];
    protected $validationMessages = [
        'cod_sinc' => ['required' => 'Campo obrigatorio'],
        'peso' => ['required' => 'Campo obrigatorio'],
        'ativo' => ['required' => 'Campo obrigatorio'],
    ];

}
