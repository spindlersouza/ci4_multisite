<?php

namespace App\Models\Front;

use CodeIgniter\Model;

class ClientesModel extends Model {

    protected $table = 'clientes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'tipo_id', 'ativo', 'cod_sinc', 'nome', 'cpf', 'data_nascimento', 'telefone', 'celular',
        'cep', 'estado_id', 'cidade_id', 'endereco', 'numero', 'complemento', 'bairro',
        'email', 'senha', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $useAutoIncrement = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $skipValidation = false;
    protected $validationRules = [
        'email' => 'required|is_unique[clientes.email]',
        'nome' => 'required',
        'senha' => 'required',
        'cpf' => 'required',
        'data_nascimento' => 'required',
        'celular' => 'required',
        'cep' => 'required',
        'estado_id' => 'required',
        'cidade_id' => 'required',
        'bairro' => 'required',
        'endereco' => 'required',
        'numero' => 'required',
    ];
    protected $validationMessages = [
        'email' => ['required' => 'Campo obrigatorio', 'is_unique' => 'Email já cadastrado'],
        'nome' => ['required' => 'Campo obrigatorio'],
        'senha' => ['required' => 'Campo obrigatorio'],
        'cpf' => ['required' => 'Campo obrigatorio'],
        'data_nascimento' => ['required' => 'Campo obrigatorio'],
        'celular' => ['required' => 'Campo obrigatorio'],
        'cep' => ['required' => 'Campo obrigatorio'],
        'estado_id' => ['required' => 'Campo obrigatorio'],
        'cidade_id' => ['required' => 'Campo obrigatorio'],
        'endereco' => ['required' => 'Campo obrigatorio'],
        'bairro' => ['required' => 'Campo obrigatorio'],
        'numero' => ['required' => 'Campo obrigatorio'],
    ];

}
