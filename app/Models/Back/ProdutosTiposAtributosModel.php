<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class ProdutosTiposAtributosModel extends Model {

    protected $table = 'produtos_tipo_atributos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'cod_sinc', 'tipo', 'created_usuario_id', 'created_at', 'updated_at', 'deleted_at'
        ];
    protected $useAutoIncrement = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $skipValidation = false;
    protected $validationRules = [
        'tipo' => 'required',
        'cod_sinc' => 'required',
    ];
    protected $validationMessages = [
        'tipo' => ['required' => 'Campo obrigatorio'],
        'cod_sinc' => ['required' => 'Campo obrigatorio'],
    ];

}
