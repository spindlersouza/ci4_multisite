<?php

namespace App\Models\Back;

use CodeIgniter\Model;

class CupomModel extends Model {

    protected $table = 'cupom';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'site_id', 'tipo', 'nome', 'codigo', 'valor', 'data_inicio', 'data_fim', 'ativo', 'created_at', 'updatet_at'
    ];
    protected $useAutoIncrement = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $skipValidation = false;
    protected $validationRules = [
        'nome' => 'required',
        'site_id' => 'required',
        'codigo' => 'required',
        'valor' => 'required',
        'tipo' => 'required',
        'data_inicio' => 'required',
        'data_fim' => 'required',
    ];
    protected $validationMessages = [
        'nome' => ['required' => 'Campo obrigatorio'],
        'site_id' => ['required' => 'Campo obrigatorio'],
        'codigo' => ['required' => 'Campo obrigatorio'],
        'valor' => ['required' => 'Campo obrigatorio'],
        'tipo' => ['required' => 'Campo obrigatorio'],
        'data_inicio' => ['required' => 'Campo obrigatorio'],
        'data_fim' => ['required' => 'Campo obrigatorio'],
    ];

}
