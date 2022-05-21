<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\CidadeModel;
use App\Models\Back\EstadoModel;
use App\Models\Back\LojasModel;

class Lojas extends BaseController {

    protected $lojas;
    protected $estados;
    protected $cidades;
    protected $sites;
    protected $data;

    public function __construct() {
        helper(['url', 'form']);
        $this->lojas = new LojasModel();
        $this->estados = new EstadoModel();
        $this->cidades = new CidadeModel();
        $this->sites = new SiteModel();
        $this->data = [
            'estados' => $this->estados->get()->getResult('array'),
            'sites' => $this->sites->whereIn('id', ['1','2','3'])->get()->getResult('array')
        ];
    }

    public function index() {

        $this->data['lojas'] = $this->lojas->select('lojas.id, lojas.localizacao, lojas.telefone, lojas.whatsapp, cidade.nome AS cidade, estado.uf AS uf')
                        ->join('cidade', 'cidade.id = lojas.cidade_id')
                        ->join('estado', 'estado.id = lojas.estado_id')
                        ->get()->getResult('array');
        echo view('Back/Lojas/index', $this->data);
    }

    public function cadastro($id = null) {
        if ($id) {
            $lojas = $this->lojas->where('id', $id)->first();
            $this->data['result'] = $lojas;
            $this->data['cidades'] = $this->cidades->where('estado_id', $lojas['estado_id'])->get()->getResult('array');
        }
        $this->data['tipo'] = 'Cadastrar';
        echo view('Back/Lojas/cadastro', $this->data);
    }

    public function save() {
        $rules = [
            'estado_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
            'cidade_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
            'localizacao' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
            'telefone' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
            'whatsapp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
            'site_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
        ];

        $validation = $this->validate($rules);

        if (!$validation) {
            $data = [
                'tipo' => 'validando',
                'validation' => $this->validator,
                'sites' => $this->sites->get()->getResult('array'),
                'estados' => $this->estados->get()->getResult('array')
            ];
            if ($this->request->getPost('estado_id') != '') {
                $data['cidades'] = $this->cidades->where('estado_id', $this->request->getPost('estado_id'))->get()->getResult('array');
            }
            echo view('Back/Lojas/cadastro', $this->data);
        } else {
            $values = [
                'localizacao' => $this->request->getPost('localizacao'),
                'telefone' => $this->request->getPost('telefone'),
                'whatsapp' => $this->request->getPost('whatsapp'),
                'estado_id' => $this->request->getPost('estado_id') ?? '',
                'cidade_id' => $this->request->getPost('cidade_id') ?? '',
                'site_id' => $this->request->getPost('site_id') ?? '',
            ];

            if ($this->request->getPost('id') != '') {
                $values['id'] = $this->request->getPost('id');
            }
            $query = $this->lojas->save($values);
            if (!$query) {
                return redirect()->back()->with('erro', 'Erro ao cadastrar');
            } else {
                return redirect()->to('admin/lojas')->with('sucesso', 'Cadastrado com sucesso');
            }
        }
    }

}
