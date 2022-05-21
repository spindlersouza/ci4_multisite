<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\DuvidasModel;

class Duvidas extends BaseController {

    protected $duvidas;

    public function __construct() {
        helper(['url', 'form']);
        $this->duvidas = new DuvidasModel();
    }

    public function index() {
        $data['duvidas'] = $this->duvidas->get()->getResult('array');
        echo view('Back/Duvidas/index', $data);
    }

    public function cadastro($id = null) {
        if ($id) {
            $data['result'] = $this->duvidas->where('id', $id)->first();
        }
        $sites = new SiteModel();
        $data['tipo'] = 'Cadastrar';
        $data['sites'] = $sites->whereIn('id', ['1','2','3'])->get()->getResult('array');
        echo view('Back/Duvidas/cadastro', $data);
    }

    public function save() {
        $rules = [
            'site_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
            'duvida' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
            'resposta' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
        ];

        $validation = $this->validate($rules);

        if (!$validation) {
            $sites = new SiteModel();
            $data = [
                'tipo' => 'validando',
                'validation' => $this->validator,
                'sites' => $sites->get()->getResult('array'),
            ];
            echo view('Back/Duvidas/cadastro', $data);
        } else {

            $values = [
                'duvida' => $this->request->getPost('duvida'),
                'resposta' => $this->request->getPost('resposta'),
                'site_id' => $this->request->getPost('site_id') ?? '',
            ];

            if ($this->request->getPost('id') != '') {
                $values['id'] = $this->request->getPost('id');
            }
            $query = $this->duvidas->save($values);
            if (!$query) {
                return redirect()->back()->with('erro', 'Erro ao cadastrar');
            } else {
                return redirect()->to('admin/duvidas')->with('sucesso', 'Cadastrado com sucesso');
            }
        }
    }

}
