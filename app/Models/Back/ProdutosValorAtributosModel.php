<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class ProdutosValorAtributosModel extends Model {

    protected $table = 'produtos_valor_atributos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'valor', 'imagem', 'cod_sinc', 'ordem', 'produtos_tipo_atributos_id', 'created_usuario_id', 'created_at','updated_at', 'deleted_at'
    ];
    protected $useAutoIncrement = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $skipValidation = false;
    protected $validationRules = [
        'valor' => 'required',
        'cod_sinc' => 'required',
    ];
    protected $validationMessages = [
        'valor' => ['required' => 'Campo obrigatorio'],
        'cod_sinc' => ['required' => 'Campo obrigatorio'],
    ];

}
