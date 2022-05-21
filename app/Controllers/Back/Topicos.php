<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\TopicosModel;

class Topicos extends BaseController {

    protected $topicos;
    protected $sites;
    protected $data;

    public function __construct() {
        helper(['url', 'form']);
        $this->topicos = new TopicosModel();
        $this->sites = new SiteModel();
        $this->data = [
            'sites' => $this->sites->whereIn('id', ['1','2','3'])->get()->getResult('array')
        ];
    }

    public function index() {
        $this->data['topicos'] = $this->topicos->select('id, icone, titulo, texto, link, site_id')->get()->getResult('array');
        echo view('Back/Topicos/index', $this->data);
    }

    public function cadastro($id = null) {
        if ($id) {
            $this->data['result'] = $this->topicos->where('id', $id)->first();
        }
        
        $this->data['tipo'] = 'Cadastrar';
        echo view('Back/Topicos/cadastro', $this->data);
    }

    public function save() {
        $rules = [
            'icone' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
            'titulo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
            'texto' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
            'link' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Campo obrigatório',
                ],
            ],
        ];

        $validation = $this->validate($rules);

        if (!$validation) {
            $data = [
                'validation' => $this->validator,
                'sites' => $this->sites->get()->getResult('array'),
            ];
            echo view('Back/Topicos/cadastro', $this->data);
        } else {
            $values = [
                'icone' => $this->request->getPost('icone') ?? '',
                'titulo' => $this->request->getPost('titulo') ?? '',
                'texto' => $this->request->getPost('texto') ?? '',
                'link' => $this->request->getPost('link') ?? '',
                'site_id' => $this->request->getPost('site_id') ?? '',
            ];

            if ($this->request->getPost('id') != '') {
                $values['id'] = $this->request->getPost('id');
            }
            $query = $this->topicos->save($values);
            if (!$query) {
                return redirect()->back()->with('erro', 'Erro ao cadastrar');
            } else {
                return redirect()->to('admin/topicos')->with('sucesso', 'Cadastrado com sucesso');
            }
        }
    }

}
