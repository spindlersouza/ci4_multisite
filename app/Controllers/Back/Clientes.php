<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Front\ClientesModel;

class Clientes extends BaseController {

    protected $clientes;
    protected $data;
    protected $sites;

    public function __construct() {
        
        helper(['url', 'form']);
        $this->clientes = new ClientesModel();
        $this->sites = new SiteModel();
        
    }

    public function index() {

        $this->data['clientes'] = $this->clientes->select(''
                . ' clientes.id, clientes.nome, clientes.email, clientes.cpf, clientes.data_nascimento, '
                . ' clientes.cep, clientes.endereco, clientes.numero, clientes.complemento, clientes.bairro,'
                . ' estado.uf AS uf, cidade.nome AS cidade,'
                . ' clientes.telefone, clientes.celular, clientes.created_at')
                ->join('estado', 'estado.id = clientes.estado_id')
                ->join('cidade', 'cidade.id = clientes.cidade_id')
                ->get()->getResult('array');
        echo view('Back/Clientes/index', $this->data);
    }

}
